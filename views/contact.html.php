
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

<section class="pt-5 wow fadeIn">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="c1">Contacto</h4>
            </div>
            <div class="col-12 pt-2">
                <p>Escribenos un mensaje y comunícate con nosotros, responderemos a la brevedad tus dudas y consultas. Sigue también nuestras redes sociales.</p>
            </div>
        </div>
    </div>
</section>

<section class="pb-5 pt-4">
  <div class="container contactoForm">
    <div class="row">
      <div class="col-12 offset-lg-3 col-lg-6 p-2 p-sm-5 wow fadeIn">
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
        <form class="" role="form" name="formulario" id="formulario" method="post" action="/contact">
          <span class="form-group">
            <div class="col item-form pb-3">
              <input class="form-control borderc3 anim" type="text" name="name" id="nombre" required/>
              <label class="c3 anim" for="nombre">Nombre</label>
            </div>
          </span>
          <span class="form-group">
            <div class="col item-form pb-3">
              <input class="form-control borderc3 anim" type="email" name="email" id="email" required/>
              <label class="c3 anim" for="email">E-mail</label>
            </div>
          </span>
          <span class="form-group">
            <div class="col item-form pb-3">
              <input class="form-control borderc3 anim" type="tel" name="telephone" id="telefono" required/>
              <label class="c3 anim" for="telefono">Teléfono</label>
            </div>
          </span>
          <span class="form-group">
            <div class="col item-form pb-3">
              <textarea class="form-control borderc3 anim" rows="6" name="message" id="consulta" required></textarea>
              <label class="c3 anim" for="consulta">Mensaje</label>
            </div>
          </span>
          <div class="col text-right">
            <button type="submit" class="enviar anim bgc1 c2 hover-c2">Enviar Consulta</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
