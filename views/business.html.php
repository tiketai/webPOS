<?php defined('TIKETAI_FLOW') OR exit('No direct script access allowed'); ?>

    <header class="container-fluid top borderc1">

        <div class="row">
            <div class="col topSep">
                <svg height="0" width="0">
                    <clipPath id="svgPath">
                        <path d="M163.7,19.7c0-3.3,2.6-5.9,5.9-5.9V-0.3H0.4v14.1c3.3,0,5.9,2.6,5.9,5.9s-2.6,5.9-5.9,5.9v14.1h169.3V25.6C166.4,25.6,163.7,23,163.7,19.7z"/>
                    </clipPath>
                </svg>
            </div>
        </div>

        <?php if ( ! empty( $featured_events )): ?>
            <div class="row">
                <div class="col p-0 bigSlide">
                    <?php foreach ($featured_events as $event): ?>
                        <div class="item">
                            <div class="bgSlide" style="background-image:url(<?php echo $event->image ?>)"></div>
                            <a href="/event/<?php echo $event->slug ?>">
                                <div class="contSlide text-center">
                                    <img src="<?php echo $event->image ?>" alt="<?php echo $event->name ?>">
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="row topIn" style="background-image:url(<?php echo $business->header_image ?>);background-size: cover;background-position: center;">
                <div class="col-12 col-md-7 col-lg-6 col-xl-4 m-auto text-center wow fadeIn">
                    <h2 class="bl"><?php echo $business->description_text ?></h2>
                    <p class="col-12 p-0 bl"><?php echo $business->description_subtext ?></p>
                </div>
            </div>
        <?php endif; ?>

</header>

<section>
    <span id="comprarTickets" class="offsetter"></span>
    <div class="container pt-5 pb-5">
        <div class="row">

            <?php if ( !empty($events->data) ): ?>

                <div class="col-12 col-sm-12 col-lg-3 pl-0 pl-lg-3 pr-0 pr-lg-3 wow fadeInDown">
                    <div class="categorias">
                        <div class="icon c1"><i class="fas fa-ticket-alt"></i></div>
                        <div class="texto bgc1 c2">Categorías</div>
                        <div class="col-12 pt-4 pl-3 pb-1 pb-lg-4 pr-3">
                            <p class="mb-1">
                                <a class="c3 hover-c3" href="/"><i class="<?php echo ( empty($selected_category['id']) )? 'fas':'far' ?> mr-1 mr-lg-3 c1 hover-c1 fa-square"></i> Todos los eventos</a>
                            </p>
                            <?php if ( isset( $categories->data )): ?>
                                <?php foreach ($categories->data as $category): ?>
                                    <p class="mb-1">
                                        <a class="c3 hover-c3" href="/category/<?php echo urlencode($category->name) ?>/<?php echo $category->id ?>/"><i class="<?php echo ( isset($selected_category) && $selected_category['id'] == $category->id )? 'fas':'far' ?> mr-1 mr-lg-3 c1 hover-c1 fa-square"></i> <?php echo ucfirst($category->name) ?></a>
                                    </p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-lg-9 wow fadeInDown">
                    <form role="form" name="formulario" id="formulario" method="get" action="/">
                        <div class="row buscarBar mb-3">

                            <div class="col-10 col-md-4 pt-3 pl-2 pb-3 pr-0">
                                <div class="col item-form">
                                    <input class="form-control c3 anim" type="text" name="search" value="<?php echo $search ?>" id="buscar"/>
                                    <label class="anim c3" for="buscar">Buscar</label>
                                </div>
                            </div>

                            <div class="col-2 col-md-4 pt-3 pl-0 pb-3 pr-2">
                                <button id="enviar" class="c2 bgc1 hover-c2 buscar anim" type="submit">
                                    <i class="c2 fas fa-search"></i>
                                </button>
                            </div>

                            <div class="orden text-right col-12 col-md-4 pt-3 pl-2 pb-3 pr-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle no-rad anim" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ordenar por<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right no-rad p-2">
                                        <li><a href="<?php echo $base_uri ?>/?order=near<?php echo ( empty($search)? '':'&search='.$search ) ?>"><?php echo ( $order == 'near')? '<i class="fas fa-circle"></i> ':''  ?>Próximos primero</a></li>
                                        <li><a href="<?php echo $base_uri ?>/?order=far<?php echo ( empty($search)? '':'&search='.$search ) ?>"><?php echo ( $order == 'far')? '<i class="fas fa-circle"></i> ':''  ?>Lejanos primero</a></li>
                                        <li><a href="<?php echo $base_uri ?>/?order=newer<?php echo ( empty($search)? '':'&search='.$search ) ?>"><?php echo ( $order == 'newer')? '<i class="fas fa-circle"></i> ':''  ?>Últimos publicados</a></li>
                                        <li><a href="<?php echo $base_uri ?>/?order=older<?php echo ( empty($search)? '':'&search='.$search ) ?>"><?php echo ( $order == 'older')? '<i class="fas fa-circle"></i> ':''  ?>Orden de publicación</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </form>

                    <div class="row tickets">
                        <?php foreach ($events->data as $event): ?>
                            <div class="col-12 mb-5 mb-md-4 item anim borderc1">
                                <div class="row m-0">
                                    <div class="col-2 p-0 preFoto">
                                        <div class="foto" style="background-image:url(<?php echo $event->image ?>);"></div>
                                    </div>
                                    <div class="col-12 col-sm-9 col-md-7 d-flex align-items-center">
                                        <div class="mw-100">
                                            <p class="categoria c1"><?php echo $event->event_category->name ?></p>
                                            <h3 class="m-0 c3"><?php echo $event->name ?></h3>
                                            <div class="sep mt-2 mb-2"></div>
                                            <p><i class="fas fa-map-marker-alt"></i><?php echo $event->location ?>, <?php echo $event->city ?>, <?php echo $event->municipality->province->region->country_code ?></p>
                                            <p><i class="fas fa-clock"></i><?php echo ucfirst(utf8_encode(strftime( '%A %e-%h-%y %H:%M', strtotime( $event->start_date)))) ?> hrs.</p>
                                        </div>
                                    </div>
                                    <div class="corteTicket"></div>
                                    <div class="col-12 col-md-3 text-right d-flex align-items-center">
                                        <div>
                                            <a class="comprar anim bgc1 c2 hover-c2" href="/event/<?php echo $event->slug ?>">
                                                Comprar Tickets
                                            </a>
                                            <?php if ( $event->price_start_at === NULL ): ?>
                                                <h3 class="c1 mt-2"><span>Sin entradas disponibles</span></h3>
                                            <?php else: ?>
                                                <h3 class="c1 mt-2"><span>Precios desde</span> $<?php echo number_format($event->price_start_at,0,',','.') ?></h3>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php if ( $events->last_page > 1 ): ?>
                            <div class="col-12 p-0 paginador">
                                <?php for ($i=1; $i <= $events->last_page ; $i++): ?>
                                    <a class="bgc3 c2 hover-bgc1 hover-c2 <?php echo ( $i == $events->current_page )? 'bgc1':'' ?> anim" href="<?php echo $base_uri ?>/?page=<?php echo $i ?>&order=<?php echo $order ?><?php echo ( empty($search)? '':'&search='.$search ) ?>"><?php echo $i ?></a>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="col">
                    <h5>Sin eventos disponibles</h5>
                    <p class="card-text">Síguenos en redes sociales para estar al tanto de las novedades.</p>
                    <div class="">
                        <?php if ( ! empty( $business->facebook )): ?>
                        <a href="<?php echo $business->facebook ?>"><i style="padding:11px;font-size:13pt;border-radius:20pt;" class="c2 bgc1 hover-c2 m-1 anim fab fa-facebook"></i></a>
                        <?php endif; ?>
                        <?php if ( ! empty( $business->instagram )): ?>
                        <a href="<?php echo $business->instagram ?>"><i style="padding:11px;font-size:13pt;border-radius:20pt;" class="c2 bgc1 hover-c2 m-1 anim fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if ( ! empty( $business->twitter )): ?>
                        <a href="<?php echo $business->twitter ?>"><i style="padding:11px;font-size:13pt;border-radius:20pt;" class="c2 bgc1 hover-c2 m-1 anim fab fa-twitter"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
