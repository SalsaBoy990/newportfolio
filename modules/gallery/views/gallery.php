<section class="simple-gallery-container">

    <h1>Simple Gallery</h1>

    <?php flashdata('<div class="alert success">', '</div>') ?>

    <p>
        <a href="<?= BASE_URL . 'gallery/form' ?>">Upload image to the gallery</a>
    </p>

    <h2>Lightbox</h2>
    <div class="simple-gallery" x-data="lightboxData">
        <div x-show="openLighbox" class="gallery-modal black" :class="{'show': openLighbox }">
                <span class="text-white white-transparent fs-24 hover-text-grey-20 padding-0-5 topright pointer z-3"
                      title="Close Lightbox" @click="closeLightbox()" style="line-height: 1">&times;</span>
            <div class="modal-content content-1024">

                <div class="margin-left-right-auto">
                    <?php foreach ($images as $index => $image) { ?>
                        <img class="lightbox-item" src="<?= 'gallery_module/'.$image->image_path ?>"
                             alt="<?= $image->image_title ?>">
                    <?php } ?>

                    <div class="row black center">
                        <div class="box relative">
                            <p id="lightbox-caption-id" class="text-center"></p>
                            <span class="middle hover-text-accent padding-0-5 large pointer" style="left:4%"
                                  @click="stepLightbox(-1)" title="Previous image">&#10094;</span>
                            <span class="middle hover-text-accent padding-0-5 large pointer" style="left:96%"
                                  @click="stepLightbox(1)" title="Next image">&#10095;</span>
                        </div>

                        <div class="simple-gallery-image-navigation">
                            <?php foreach ($images as $index => $image) { ?>
                                <div>
                                    <img class="lightbox-dots opacity hover-opacity-off pointer opacity-off"
                                         src="<?= 'gallery_module/'.$image->image_path ?>"
                                         @click="currentLightbox('<?= $index + 1 ?>')" alt="<?= $image->image_title ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div> <!-- End row -->
                </div> <!-- End clean-content -->

            </div> <!-- End modal content -->
        </div> <!-- End modal -->

        <div class="row-padding">
            <div class="gallery">
                <?php foreach ($images as $index => $image) { ?>
                    <div class="gallery-item w-2 h-1">
                        <div class="image">
                            <img src="<?= 'gallery_module/'.$image->image_path ?>"
                                 @click="openLightbox();currentLightbox('<?= $index + 1 ?>')"
                                 class="single-image img-fluid"
                                 alt="<?= $image->image_title ?>">
                        </div>
                        <div class="text"><?= $image->image_title ?></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <hr>

    <h2>Image slider</h2>

    <div x-data="sliderData" x-init="slideItemClass = 'slide-item'; slideDotsClass = 'slide-dots';"
         class="simple-gallery-slider content-960 margin-left-right-auto relative">

        <?php foreach ($images as $index => $image) { ?>
            <div class="relative slide-item">
                <img src="<?= 'gallery_module/'.$image->image_path ?>" alt="<?= $image->image_title ?>">
                <div class="topleft padding-1 text-white black-transparent fs-14">
                    <?= ($index + 1).' / '.$number_of_images ?>
                </div>
                <div class="topright text-white black-transparent padding-1 hide-mobile">
                    <?= $image->image_title ?>
                </div>
            </div>
        <?php } ?>

        <div class="slider-nav center section fs-18 text-white bottomleft">
            <div class="float-left hover-text-accent padding-0-5 large pointer" @click="switchSlide(-1)">&#10094;</div>
            <div class="float-right hover-text-accent padding-0-5 large pointer" @click="switchSlide(1)">&#10095;</div>
            <div class="margin-top-1 text-center">
                <?php for ($i = 1; $i <= $number_of_images; $i++) { ?>
                    <span class="slide-dots border hover-white" @click="currentSlide('<?= $i ?>')"></span>
                <?php } ?>
            </div>

        </div>
    </div>


</section>
