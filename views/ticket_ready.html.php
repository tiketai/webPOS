<header class="container-fluid top borderc1">
    <div class="row">
        <div class="col topSep"></div>
    </div>
    <div class="row">
        <div class="col p-0 bgEvento">
            <div class="bgEventoImg" style="background-image:url(<?php echo $business->header_image ?>)">
                <div class="bgFiltro"></div>
            </div>
        </div>
    </div>
</header>

<section class="pt-5">
    <div class="container cabecera p-5 bgc1 borderc3">
        <div class="row">
            <div class="col-12">
                <h4 class="c2">Ticket completo #<?php echo $ticket->id ?></h4>
            </div>
            <div class="col-12 pt-0">
                <p class="c2 m-0"><b><?php echo $ticket->event->name ?></b> <?php echo date('d/m/Y H:i', strtotime($ticket->event->start_date)) ?></p>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container contactoForm">
        <div class="row">
            <div class="col-12 offset-lg-1 col-lg-10 p-2 p-sm-5 wow fadeIn">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <table class="table">
                            <tr>
                                <td class="border-0">
                                    <small><strong>Nombre completo</strong></small><br>
                                    <?php echo $ticket->owner_name ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small><strong>RUN/DNI</strong></small><br>
                                    <?php echo $ticket->owner_dni ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-bottom">
                                    <small><strong>Email</strong></small><br>
                                    <?php echo $ticket->owner_email ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 col-lg-6">
                        <table class="table">
                            <tr>
                                <td class="border-0">
                                    <small><strong>Teléfono</strong></small><br>
                                    <?php echo $ticket->owner_phone ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small><strong>Fecha de nacimiento</strong></small><br>
                                    <?php echo date('d/m/Y', strtotime($ticket->owner_birthday)) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-bottom">
                                    <small><strong>Género</strong></small><br>
                                    <?php echo str_replace( array('M','F','O'), array('Masculino', 'Femenino', 'Sin especificar'), $ticket->owner_gender) ?>
                                </td>
                            </tr>
                        </table>
                        <div class="col-12 p-0 text-right">
                            <a class="boton anim bgc1 c2 hover-c2 mt-3 mb-1" href="/ticket-download/<?php echo $ticket->event->slug ?>/<?php echo $ticket->order->internal_token ?>/<?php echo $ticket->token ?>">Descargar ticket</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
