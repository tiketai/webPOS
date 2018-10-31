<?php
define( 'TIKETAI_FLOW' , true );
define( 'API_URL' , 'https://api-dev.tiket.ai/api/' );


require_once 'system/limonade/limonade.php';
require_once 'system/requests/Requests.php';

Requests::register_autoloader();



    function configure()
    {
        option('base_uri', '/');
        option('views_dir', 'views');
    }

    require_once 'config.php';


    dispatch('/', 'business');
    dispatch('/category/:category_name/:category_id', 'business');

        function business()
        {
            $selected_category['id'] = params('category_id');
            $selected_category['name'] = params('category_name');

            $actual_page = ( isset( $_GET['page'] ) )? $_GET['page'] : 1;
            $order = ( isset( $_GET['order'] ) )? $_GET['order'] : 'near';
            $search = ( isset( $_GET['search'] ) )? $_GET['search'] : '';

            // GET BUSINESS
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN);
            $business = json_decode( $response->body );

            if ( isset($business->success) AND $business->success === false ) {
                exit('miss subdomain configuration');
            }

            $category_query = ( empty($selected_category['id']) )? '':'&event_category_id='.$selected_category['id'];
            $base_uri = ( empty($selected_category['id']) )? '':'/category/'.$selected_category['name'].'/'.$selected_category['id'];

            // GET EVENTS
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events?when=newer&published=true&page='.$actual_page.'&order='.$order.'&search='.$search.$category_query);
            $events = json_decode( $response->body );

            if ( ! empty($events->current_page) && $events->current_page > 1 && empty($events->data)) {
                halt(NOT_FOUND);
            }

            if (! empty( $events->data )) {
                for ($i=0; $i < count($events->data); $i++) {
                    $events->data[$i]->price_start_at = NULL;
                    if ( ! empty($events->data[$i]->groups) ) {
                        foreach ($events->data[$i]->groups as $group) {
                            if ( ! empty($group->fares) ) {
                                foreach ($group->fares as $fare) {
                                    if ( empty($events->data[$i]->price_start_at) || ($fare->price + $fare->comision) < $events->data[0]->price_start_at ) {
                                        $events->data[$i]->price_start_at = ($fare->price + $fare->comision);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // GET FEATURED EVENTS
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events?featured=true&published=true&page=1&limit=100');
            $featured_events = json_decode( $response->body );
            $featured_events = $featured_events->data;

            // GET CATEGORIES
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/event_categories');
            $categories = json_decode( $response->body );

            set('business', $business);
            set('events', $events);
            set('featured_events', $featured_events);
            set('categories', $categories);
            set('title', $business->name);
            set('order', $order);
            set('search', $search);
            set('selected_category', $selected_category);
            set('base_uri', $base_uri);

            return render('business.html.php', 'layout.html.php');
        }

    dispatch('/tos', 'tos');
        function tos()
        {
            // GET BUSINESS
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN);
            $business = json_decode( $response->body );

            if ( isset($business->success) AND $business->success === false ) {
                exit('miss subdomain configuration');
            }

            set('business', $business);
            set('title', 'Términos y condiciones');
            set('menu_simple', true);
            set('body_classes', 'contacto');

            return render('tos.html.php', 'layout.html.php');
        }


    dispatch('/contact', 'contact');
        function contact( $feedback = NULL, $success = NULL )
        {
            // GET BUSINESS
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN);
            $business = json_decode( $response->body );

            if ( isset($business->success) AND $business->success === false ) {
                exit('miss subdomain configuration');
            }

            set('business', $business);
            set('feedback', $feedback);
            set('success', $success);
            set('title', 'Contácto');
            set('menu_simple', true);
            set('body_classes', 'contacto');

            return render('contact.html.php', 'layout.html.php');
        }

    dispatch_post('/contact', 'contact_action');
        function contact_action()
        {
            if ( empty( $_POST['name'])) {
                echo contact( 'Nombre es requerido' );
                return;
            }
            if ( empty( $_POST['email']) || ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                echo contact( 'Mail es requerido' );
                return;
            }
            if ( empty( $_POST['message']) ) {
                echo contact( 'Mensaje es requerido' );
                return;
            }

            $data = array('full_name' => $_POST['name'], 'email' => $_POST['email'], 'telephone' => $_POST['telephone'], 'message' => $_POST['message'] );
            $response = Requests::post(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/contacts', array(), $data);

            echo contact( NULL, 'Mensaje enviado' );
        }

    dispatch('/event/:event_slug', 'event');
        function event()
        {
            $event_slug = params('event_slug');
            if ( empty($event_slug) ) {
                halt(NOT_FOUND);
            }

            // GET BUSINESS
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN);
            $business = json_decode( $response->body );

            if ( isset($business->success) AND $business->success === false ) {
                exit('miss subdomain configuration');
            }

            // GET EVENT
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug);
            $event = json_decode( $response->body );

            if ( isset($event->success) AND $event->success === false ) {
                halt(NOT_FOUND);
            }

            // GET Groups
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug.'/groups');
            $groups = json_decode( $response->body );

            $fares = array();
            if ( ! empty( $groups->data )) {
                foreach ($groups->data as $group) {

                    if ( strtotime( $group->tickets_available_at ) <= time() && strtotime( $group->tickets_unavailable_at ) >= time() ) {

                        // GET Fares
                        $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug.'/groups/'.$group->id.'/fares');
                        $fares_body = json_decode( $response->body );
                        $fares[ $group->id ] = $fares_body->data;

                    }

                }
            }


            // GET SPONSORS
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug.'/event_sponsors');
            $sponsors = json_decode( $response->body );

            set('business', $business);
            set('event', $event);
            set('groups', $groups);
            set('fares', $fares);
            set('sponsors', $sponsors);
            set('title', $event->name);
            set('body_classes', 'evento');

            return render('event.html.php', 'layout.html.php');
        }


    dispatch_post('/event/:event_slug', 'event_action');
        function event_action()
        {
            $event_slug = params('event_slug');
            if ( empty($event_slug) ) {
                halt(NOT_FOUND);
            }

            // GET BUSINESS
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN);
            $business = json_decode( $response->body );

            if ( isset($business->success) AND $business->success === false ) {
                exit('miss subdomain configuration');
            }

            // GET EVENT
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug);
            $event = json_decode( $response->body );

            if ( isset($event->success) AND $event->success === false ) {
                halt(NOT_FOUND);
            }

            // GET Groups
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug.'/groups');
            $groups = json_decode( $response->body );
            $fares = array();
            if ( ! empty( $groups->data )) {
                foreach ($groups->data as $group) {

                    if ( strtotime( $group->tickets_available_at ) <= time() && strtotime( $group->tickets_unavailable_at ) >= time() ) {

                        // GET Fares
                        $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug.'/groups/'.$group->id.'/fares');
                        $fares_body = json_decode( $response->body );
                        if ( ! empty( $fares_body->data ) && is_array( $fares_body->data ) ) {
                            $fares = array_merge( $fares, $fares_body->data );
                        }

                    }

                }
            }

            $data = array();
            $total = 0;
            if ( ! empty($fares) ) {
                foreach ($fares as $fare) {
                    if ( isset($_POST[ 'fare-'.$fare->id ]) && ! empty( $_POST[ 'fare-'.$fare->id ] ) && $_POST[ 'fare-'.$fare->id ] > 0 ) {
                        $data['fare'][ $fare->id ] = $_POST[ 'fare-'.$fare->id ];
                        $total = $fare->price + $fare->comision;
                    }
                }
            }

            if ( empty( $data ) ) {
                return message( 'La cantidad de tickets debe ser mayor que cero.' );
            }

            $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

            $data['success_url'] = $base_url.'/payment/success';
            $data['error_url'] = $base_url.'/payment/failure';
            $data['email'] = $_POST['email'];
            $response = Requests::post(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug.'/orders', array(), $data);
            $response = json_decode($response->body);

            if ( ! $response->success ) {
                echo message( 'Problemas al procesar los tickets, intente nuevamente' );
                exit();
            }

            if ( $response->data->order->order_status != 1) {
                echo message( 'Tu compra no esta pagada' );
                exit();
            }

            if ( $total > 0 ) {
                return redirect_to($response->data->success_url);
            }

            if ( sizeof( $response->data->order->tickets ) == 1 ) {
                return redirect_to("/complete-ticket/".$event_slug."/".$response->data->order->internal_token."/".$response->data->order->tickets[0]->token);
            }


            set('order', $response->data->order);
            set('business', $business);
            set('event', $event);
            set('title', 'Entrega de tickets');
            set('menu_simple', true);
            set('body_classes', 'contacto');

            return render('order_ready.html.php', 'layout.html.php');

        }



        dispatch('/complete-ticket/:event_slug/:order_token/:ticket_token', 'complete_ticket');
            function complete_ticket()
            {
                // GET BUSINESS
                $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN);
                $business = json_decode( $response->body );

                if ( isset($business->success) AND $business->success === false ) {
                    exit('miss subdomain configuration');
                }

                $ticket_token = params('ticket_token');
                if ( empty($ticket_token) ) {
                    halt(NOT_FOUND);
                }
                $order_token = params('order_token');
                if ( empty($order_token) ) {
                    halt(NOT_FOUND);
                }
                $event_slug = params('event_slug');
                if ( empty($event_slug) ) {
                    halt(NOT_FOUND);
                }

                // GET TICKET
                $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug.'/orders/'.$order_token.'/tickets/'.$ticket_token);
                if ( $response->status_code != 200 ) {
                    halt(NOT_FOUND);
                }
                $ticket = json_decode( $response->body );

                if ( $ticket->owner_name != NULL ) {
                    return redirect_to("/ticket-ready/$event_slug/$order_token/$ticket_token");
                }

                set('ticket', $ticket);
                set('business', $business);
                set('title', 'completar ticket');
                set('menu_simple', true);
                set('body_classes', 'contacto');
                return render('complete_ticket.html.php', 'layout.html.php');
            }



        dispatch_post('/complete-ticket/:event_slug/:order_token/:ticket_token', 'complete_ticket_action');
            function complete_ticket_action()
            {
                $ticket_token = params('ticket_token');
                if ( empty($ticket_token) ) {
                    halt(NOT_FOUND);
                }
                $order_token = params('order_token');
                if ( empty($order_token) ) {
                    halt(NOT_FOUND);
                }
                $event_slug = params('event_slug');
                if ( empty($event_slug) ) {
                    halt(NOT_FOUND);
                }

                // GET TICKET
                $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug.'/orders/'.$order_token.'/tickets/'.$ticket_token);
                if ( $response->status_code != 200 ) {
                    halt(NOT_FOUND);
                }
                $ticket = json_decode( $response->body );

                if (  ! empty($ticket->owner_name) ) {
                    return redirect_to("/ticket-ready/$event_slug/$order_token/$ticket_token");
                }

                if ( empty( $_POST['name'])) {
                    echo message( 'Nombre es requerido' );return;
                }
                if ( empty( $_POST['email']) || ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    echo message( 'email es requerido' );return;
                }
                if ( empty( $_POST['dni']) ) {
                    echo message( 'RUN/DNI es requerido' );return;
                }
                if ( empty( $_POST['phone']) ) {
                    echo message( 'Telefono es requerido' );return;
                }
                if ( empty( $_POST['birthdate']) ) {
                    echo message( 'Fecha de nacimiento es requerida' );return;
                }
                if ( empty( $_POST['gender']) ) {
                    echo message( 'Genero es requerido' );return;
                }
                $data['owner_name'] = $_POST['name'];
                $data['owner_email'] = $_POST['email'];
                $data['owner_dni'] = $_POST['dni'];
                $data['owner_phone'] = $_POST['phone'];
                $data['owner_birthday'] = $_POST['birthdate'];
                $data['owner_gender'] = $_POST['gender'];
                // print_r($data);die();
                $response = Requests::put(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug.'/orders/'.$order_token.'/tickets/'.$ticket_token, array(), $data);

                if ( isset($response->body->success) AND $response->body->success === false ) {
                    echo message( 'Problema al guardar datos, intente nuevamente' );
                }
                else {
                    return redirect_to("/ticket-ready/$event_slug/$order_token/$ticket_token");
                }

            }


        dispatch('/ticket-ready/:event_slug/:order_token/:ticket_token', 'ticket_ready');
            function ticket_ready()
            {
                // GET BUSINESS
                $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN);
                $business = json_decode( $response->body );

                if ( isset($business->success) AND $business->success === false ) {
                    exit('miss subdomain configuration');
                }

                $ticket_token = params('ticket_token');
                if ( empty($ticket_token) ) {
                    halt(NOT_FOUND);
                }
                $order_token = params('order_token');
                if ( empty($order_token) ) {
                    halt(NOT_FOUND);
                }
                $event_slug = params('event_slug');
                if ( empty($event_slug) ) {
                    halt(NOT_FOUND);
                }

                // GET TICKET
                $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug.'/orders/'.$order_token.'/tickets/'.$ticket_token);
                if ( $response->status_code != "200" ) {
                    halt(NOT_FOUND);
                }
                $ticket = json_decode( $response->body );

                if ( empty($ticket->owner_name) ) {
                    return redirect_to("/complete-ticket/$event_slug/$order_token/$ticket_token");
                }

                set('business', $business);
                set('ticket', $ticket);
                set('title', 'completar ticket');
                set('menu_simple', true);
                set('body_classes', 'contacto');
                return render('ticket_ready.html.php', 'layout.html.php');
            }

        dispatch('/ticket-download/:event_slug/:order_token/:ticket_token', 'ticket_download');
            function ticket_download()
            {
                if ( isset($business->success) AND $business->success === false ) {
                    exit('miss subdomain configuration');
                }

                $ticket_token = params('ticket_token');
                if ( empty($ticket_token) ) {
                    halt(NOT_FOUND);
                }
                $order_token = params('order_token');
                if ( empty($order_token) ) {
                    halt(NOT_FOUND);
                }
                $event_slug = params('event_slug');
                if ( empty($event_slug) ) {
                    halt(NOT_FOUND);
                }

                // GET TICKET
                $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug.'/orders/'.$order_token.'/tickets/'.$ticket_token);
                if ( $response->status_code != 200 ) {
                    halt(NOT_FOUND);
                }
                $ticket = json_decode( $response->body );

                if ( empty($ticket->owner_name) ) {
                    return redirect_to("/complete-ticket/$event_slug/$order_token/$ticket_token");
                }

                $pdf = API_URL.'businesses/'.BUSINESS_SUBDOMAIN.'/events/'.$event_slug.'/orders/'.$order_token.'/tickets/'.$ticket_token.'.pdf';
                header('Content-Type: application/pdf');
                header("Content-Transfer-Encoding: Binary");
                header("Content-disposition: attachment; filename=\"ticket#".$ticket->id.".pdf\"");
                readfile($pdf);
                exit();
            }







        function message( $message = 'Ups!')
        {
            // GET BUSINESS
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN);
            $business = json_decode( $response->body );

            if ( isset($business->success) AND $business->success === false ) {
                exit('miss subdomain configuration');
            }

            set('business', $business);
            set('message', $message);
            set('title', 'Mensaje');

            return render('message.html.php', 'layout.html.php');
        }



        function not_found($errno, $errstr, $errfile=null, $errline=null)
        {
            // GET BUSINESS
            $response = Requests::get(API_URL.'businesses/'.BUSINESS_SUBDOMAIN);
            $business = json_decode( $response->body );

            if ( isset($business->success) AND $business->success === false ) {
                exit('miss subdomain configuration');
            }

            set('business', $business);
            set('title', 'Página no encontrada');
            return render('error_404.html.php', 'layout.html.php');
        }



    run();
