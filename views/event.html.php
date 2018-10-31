<?php defined('TIKETAI_FLOW') OR exit('No direct script access allowed'); ?>

<?php content_for('ogg'); ?>
    <meta property="og:title" content="<?php echo $title ?>" />
    <meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"/>
    <meta property="og:description" content="<?php echo $event->name ?> - <?php echo $event->location ?>, <?php echo $event->city ?>, <?php echo $event->municipality->province->region->country_code ?>"/>
    <meta property="og:image" content="<?php echo $event->image ?>"/>
<?php end_content_for(); ?>

<header class="container-fluid top borderc1">
    <div class="row">
        <div class="col topSep"></div>
    </div>
    <div class="row">
        <div class="col p-0 bgEvento">
            <div class="bgEventoImg" style="background-image:url(<?php echo $event->image ?>)">
                <div class="bgFiltro"></div>
            </div>
        </div>
    </div>
</header>

<section class="pt-5">
    <div class="container pt-5">
        <div class="row pt-4">

            <div class="col-12 p-0 d-block d-md-none">
                <div class="categoria">
                    <p class="bgc1 c2 m-0"><?php echo $event->event_category->name ?></p>
                </div>
                <h3 class="p-4 c1 bgc2"><?php echo $event->name ?></h3>
                <div class="info p-3 pr-0 pl-0">
                    <p class="bl m-1"><i class="mr-2 fas fa-map-marker-alt"></i><?php echo $event->location ?>, <?php echo $event->city ?>, <?php echo $event->municipality->province->region->country_code ?></p>
                    <p class="bl m-1"><i class="mr-2 fas fa-clock"></i><?php echo ucfirst(utf8_encode(strftime( '%A %e-%h-%y %H:%M', strtotime( $event->start_date)))) ?> hrs.</p>
                </div>
            </div>

            <div id="grupoImagen" class=" ol-12 col-sm-12 col-md-6 col-lg-7 p-0 bgbl">
                <div id="foto" class="foto">
                    <img class="img-fluid" src="<?php echo $event->image ?>" alt="<?php echo $event->name ?>">
                </div>
                <div id="sociales" class="sociales bgc1">
                    <div class="row m-0">
                        <div class="col p-2">
                            <?php if ( ! empty( $event->facebook )): ?>
                                <a href="<?php echo $event->facebook ?>"><i class="c1 bgc2 hover-c1 m-1 anim fab fa-facebook"></i></a>
                            <?php endif; ?>
                            <?php if ( ! empty( $event->instagram )): ?>
                                <a href="<?php echo $event->instagram ?>"><i class="c1 bgc2 hover-c1 m-1 anim fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if ( ! empty( $event->twitter )): ?>
                                <a href="<?php echo $event->twitter ?>"><i class="c1 bgc2 hover-c1 m-1 anim fab fa-twitter"></i></a>
                            <?php endif; ?>
                        </div>
                        <div class="col text-right compartir p-2 pt-4">
                            <p class="m-0 text-right c2 p-2">Compartir</p>
                        </div>
                    </div>
                </div>
                <?php if ( !empty($event->lat) && !empty($event->lng) ): ?>
                    <div id="map" class="mapa">
                        <img class="img-fluid" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $event->lat .','. $event->lng ?>&zoom=15&scale=2&size=665x240&maptype=roadmap&key=AIzaSyDd5lk0Zdy1Q_dfXaP76z9U0Di5SmHodl8&format=png&visual_refresh=false&markers=size:mid%7Ccolor:0xff0000%7Clabel:Ubicaci%C3%B3n%7C<?php echo $event->lat .','. $event->lng ?>" alt="map">
                    </div>
                <?php endif; ?>

            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-5 p-0 ">
                <div id="grupoInfo" class="d-none d-md-block">
                    <div class="categoria">
                        <p class="bgc1 c2 m-0"><?php echo $event->event_category->name ?></p>
                    </div>
                    <h3 class="p-4 c1 bgc2"><?php echo $event->name ?></h3>
                    <div class="info p-4">
                        <p class="bl"><i class="mr-2 fas fa-map-marker-alt"></i><?php echo $event->location ?>, <?php echo $event->city ?>, <?php echo $event->municipality->province->region->country_code ?></p>
                        <p class="bl"><i class="mr-2 fas fa-clock"></i><?php echo ucfirst(utf8_encode(strftime( '%A %e-%h-%y %H:%M', strtotime( $event->start_date)))) ?> hrs.</p>
                    </div>
                </div>

                <div id="grupoDescripcion" class="descripcion bgbl ng">
                    <?php echo $event->description_resume ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ( isset( $event->description_details ) ): ?>
    <section class="">
        <div class="container pt-5 pb-5 bgc1 c2">
            <div class="row pt-3 pb-3 pt-sm-5 pb-sm-5 ">
                <div class="col-12 col-md-9 offset-md-1 col-lg-8 offset-lg-1 descripcion2 text-right pr-4 pl-4 pt-0 pr-sm-5 pl-sm-5 pt-md-2 pb-0 borderc2">
                    <?php echo $event->description_details ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if ( ! empty( $sponsors->data ) ): ?>
    <section class="">
        <div class="container auspiciadores pt-5 pb-5 bgbl ng">
            <div class="row">
                <div class="col-12 text-center">
                    <h3>Auspiciadores</h3>
                    <div class="col-12 text-center pt-4">
                        <?php foreach ($sponsors->data as $sponsor): ?>
                            <a href="<?php echo (empty($sponsor->link) )? '#':$sponsor->link ?>" target="_blank">
                                <div class="item anim p-2 text-center">
                                    <img src="<?php echo $sponsor->logo ?>" alt="<?php echo $sponsor->name ?>" />
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>


<?php if ( !empty( $groups->data )): ?>
<section>
    <span id="comprarTickets" class="offsetter"></span>

        <form id="form-tickets" action="/event/<?php echo $event->slug ?>" method="post">
            <div class="container tickets pt-5 pb-5 bgbl ng">
                <div class="row">
                    <div class="col-12 col-lg-10 offset-lg-1 text-center">
                        <h3>Tickets</h3>
                            <div class="col-12 text-center pt-4">

                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-left" width="50%" scope="col">Ticket</th>
                                            <th class="text-right" width="20%" scope="col">Precio</th>
                                            <th class="text-right" width="20%" scope="col">Subtotal</th>
                                            <th class="text-right" width="10%" scope="col">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($groups->data as $group): ?>
                                            <?php if ( !empty($fares[ $group->id ]) ): ?>
                                                <tr class="borderc1 border-top-0 border-left-0 border-right-0" style="border-bottom-width:2px;border-style:solid">
                                                    <th colspan="4" class="text-left c1 text-uppercase" scope="row"><?php echo $group->group_name ?></th>
                                                </tr>
                                                <?php foreach ($fares[ $group->id ] as $fare): ?>
                                                    <tr>
                                                        <th class="text-left" scope="row"><?php echo $fare->fare_name ?></th>
                                                        <td class="text-right">$ <?php echo number_format($fare->price + $fare->comision, 0, ',','.') ?> CLP</td>
                                                        <td class="text-right">$ <span id="fare-subtotal-<?php echo $fare->id ?>">0</span> CLP</td>
                                                        <td class="text-right">
                                                            <input name="fare-<?php echo $fare->id ?>" data-id="<?php echo $fare->id ?>" data-price="<?php echo ($fare->price + $fare->comision) ?>" type="number" class="fare_cant" value="0" min="0" max="<?php echo min($group->stock, 10) ?>">
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="container tickets pt-5 pb-5 bgc1 c2">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-6 text-right">
                            <div class="form-group pl-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@gmail.com" style="width:100%" required>
                                <small id="emailHelp" class="form-text text-white">Enviaremos tus tickets a esta dirección, asegurate de que esté correcta.</small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-3 col-lg-2 text-right">
                            <p class="m-1">Total</p>
                            <h3>$<span id="total">0</span> CLP</h3>
                        </div>
                        <div class="col-12 col-sm-7 col-md-5 col-lg-4 pt-4 pt-sm-0 text-left">
                          <button id="comprar-tickets" disabled type="submit" class="comprar anim bgc2 c1 hover-c1" href="#comprarTickets">Comprar Tickets</button>
                        </div>
                    </div>
                </div>

            </form>

    </section>
<?php endif; ?>

<?php if ( ! empty( $event->event_tos ) ): ?>
    <section class="mb-5">
        <div class="container terminos pt-5 pb-5 bgbl c2">
            <div class="row">
                <div class="col-12 text-center resumen pl-5">
                    <a class="ng hover-c1 anim" href="#" data-toggle="modal" data-target="#tos-modal">Términos y condiciones</a>
                </div>
            </div>
        </div>
    </section>

    <div id="tos-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="TOSModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-0 no-bor">
                <div class="modal-header">
                    <h5 class="modal-title c1 pl-md-4 pt-md-3" id="exampleModalLongTitle">Términos y Condiciones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body px-md-5">
                        <?php echo $event->event_tos ?>
                    </div>
                    <div class="modal-footer align-content-center">
                        <button type="button" class="btn btn-sm mx-auto bgc1 c2 rounded-0" data-dismiss="modal">Cerrar</button>
                    </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<?php content_for('specifics_scripts'); ?>
    <script type="text/javascript">
        $('.fare_cant').click( function() {
            var fare_id = $(this).data('id');
            var price = parseInt($(this).data('price'));
            var cant = parseInt($(this).val());
            var total;

            $('#fare-subtotal-' + fare_id).html( (price * cant).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") );
            total = calcular_total();

            if ( total.cant > 0 ) {
                $('#comprar-tickets').removeAttr('disabled', 'disabled');
                $('#form-tickets').unbind('submit');
            }
            else {
                $('#comprar-tickets').attr('disabled', 'disabled');
                $('#form-tickets').bind('submit',function(e){e.preventDefault();});
            }

            $('#total').html( total.money.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") );

        })

        function calcular_total(){
            var total = {'money':0, 'cant':0}
            $('.fare_cant').each(function() {
                var price = parseInt($(this).data('price'));
                var cant = parseInt($(this).val());
                total.money += parseInt( price * cant )
                total.cant += parseInt( cant )
            })

            return total;
        }
    </script>
<?php end_content_for(); ?>
