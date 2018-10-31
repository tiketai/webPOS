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
                <h4 class="c2">Completa tu ticket #<?php echo $ticket->id ?></h4>
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
            <div class="col-12 offset-lg-1 col-lg-10 p-3 p-sm-5">
                <?php if ( ! empty($feedback) ): ?>
                    <div class="alert alert-warning mb-5" role="alert">
                        <?php echo $feedback ?>
                    </div>
                <?php endif; ?>
                <?php if ( ! empty($success) ): ?>
                    <div class="alert alert-success mb-5" role="alert">
                        <?php echo $success ?>
                    </div>
                <?php endif; ?>
                <p>Para obtener tu ticket debes completar los siguientes datos. Una vez asignado los datos al ticket estos no pueden ser modificados y el ticket quedará nominal</p>
                <form class="pt-3" role="form" name="formulario" id="formulario" method="post" action="/complete-ticket/<?php echo $ticket->event->slug ?>/<?php echo $ticket->order->internal_token ?>/<?php echo $ticket->token ?>">
                    <div class="row">
                        <div class="col-12 col-lg-6">

                            <span class="form-group">
                              <div class="col item-form pb-3">
                                <input class="form-control borderc3 c3 anim" type="text" id="fullname-input" name="name" required/>
                                <label class="c3 anim" for="fullname-input">Nombre Completo</label>
                              </div>
                            </span>

                            <span class="form-group">
                              <div class="col item-form pb-3">
                                <input class="form-control borderc3 c3 anim" type="text" id="dni-input" name="dni" required/>
                                <label class="c3 anim" for="dni-input">RUN/DNI</label>
                              </div>
                            </span>

                            <span class="form-group">
                              <div class="col item-form pb-3">
                                <input class="form-control borderc3 c3 anim" type="text" name="email" id="email-input" required/>
                                <label class="c3 anim" for="email-input">E-mail</label>
                              </div>
                            </span>

                        </div>
                        <div class="col-12 col-lg-6">

                            <span class="form-group">
                              <div class="col item-form pb-3">
                                <input class="form-control borderc3 c3 anim" type="text" name="phone" id="phone-input" required/>
                                <label class="c3 anim" for="phone-input">Teléfono</label>
                              </div>
                            </span>

                            <span class="form-group">
                              <div class="col item-form pb-3">
                                <input class="form-control borderc3 c3 anim" type="date" name="birthdate" id="birthdate-input" required/>
                                <label class="c3 anim" for="birthdate-input">Fecha de nacimiento</label>
                              </div>
                            </span>

                            <span class="form-group">
                              <div class="col item-form pb-3">
                                <select class="form-control borderc3 c3 anim" id="gender-input" name="gender" required>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                    <option value="O">No especificado</option>
                                </select>
                                <label class="c3 anim" for="gender-input">Género</label>
                              </div>
                            </span>

                            <div class="col text-right">
                              <button type="submit" class="enviar anim bgc1 c2 hover-c2">Guardar y obtener ticket</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
