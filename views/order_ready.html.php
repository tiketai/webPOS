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
                <h4 class="c2">Tickets adquiridos</h4>
            </div>
            <div class="col-12 pt-0">
                <p class="c2 m-0"><b>Total pagado:</b> $<?php echo number_format($order->total + $order->comision, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container contactoForm">
        <div class="row">
            <div class="col-12 col-lg-7 p-3 p-sm-5">

                <p>Ahora puedes proceder a completar la identificación personal de cada ticket para completar el proceso y obtener tus tickets</p>
                <?php foreach ($order->tickets as $ticket): ?>
                    <a class="completar anim c1 hover-c1" target="_blank" href="/complete-ticket/<?php echo $event->slug ?>/<?php echo $order->internal_token ?>/<?php echo $ticket->token ?>">
                        <i class="fas fa-ticket-alt mr-1"></i> Completar ticket #<?php echo $ticket->id ?> ($<?php echo number_format($ticket->total + $ticket->comision, 0, ',', '.') ?>)
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
