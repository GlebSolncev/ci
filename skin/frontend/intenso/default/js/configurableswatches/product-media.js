/**
 * Intenso Theme Library
 * http://itactica.com/intenso
 * Copyright 2014, ITACTICA
 * http://getintenso.com/license
 */

var ConfigurableMediaImages = {
    imageType: null,
    productImages: {},
    imageObjects: {},
    swapGallery: true,

    arrayIntersect: function(a, b) {
        var ai=0, bi=0;
        var result = new Array();

        while( ai < a.length && bi < b.length )
        {
            if      (a[ai] < b[bi] ){ ai++; }
            else if (a[ai] > b[bi] ){ bi++; }
            else /* they're equal */
            {
                result.push(a[ai]);
                ai++;
                bi++;
            }
        }

        return result;
    },

    getCompatibleProductImages: function(productFallback, selectedLabels, type) {
        //find compatible products
        var compatibleProducts = [];
        var compatibleProductSets = [];
        selectedLabels.each(function(selectedLabel) {
            if(!productFallback['option_labels'][selectedLabel]) {
                return;
            }

            var optionProducts = productFallback['option_labels'][selectedLabel]['products'];
            // delete references to simple products without images
            if (type == 'additional_images') {
                optionProducts.each(function(id){
                    if (productFallback['base_image'][id] === undefined) {
                        optionProducts = jQuery.grep(optionProducts, function(value) {
                            return value != id;
                        });
                    }
                });
            }
            compatibleProductSets.push(optionProducts);

            //optimistically push all products
            optionProducts.each(function(productId) {
                compatibleProducts.push(productId);
            });
        });

        //intersect compatible products
        compatibleProductSets.each(function(productSet) {
            compatibleProducts = ConfigurableMediaImages.arrayIntersect(compatibleProducts, productSet);
        });

        return compatibleProducts;
    },

    isValidImage: function(fallbackImageUrl) {
        if(!fallbackImageUrl) {
            return false;
        }

        return true;
    },

    getSwatchImage: function(productId, optionLabel, selectedLabels, type) {
        type = typeof type !== 'undefined' ? type : ConfigurableMediaImages.imageType;
        var fallback = ConfigurableMediaImages.productImages[productId];
        if(!fallback) {
            return null;
        }

        //first, try to get label-matching image on config product for this option's label
        var currentLabelImage = fallback['option_labels'][optionLabel];
        if(currentLabelImage && fallback['option_labels'][optionLabel]['configurable_product'][type]) {
            //found label image on configurable product
            return fallback['option_labels'][optionLabel]['configurable_product'][type];
        } else if(currentLabelImage 
            && fallback['option_labels'][optionLabel]['configurable_product']['additional_images'] 
            && fallback['option_labels'][optionLabel]['configurable_product']['additional_images'][type]) {
            swapGallery = false;
            return fallback['option_labels'][optionLabel]['configurable_product']['additional_images'][type];
        }

        var compatibleProducts = ConfigurableMediaImages.getCompatibleProductImages(fallback, selectedLabels, type);

        if(compatibleProducts.length == 0) { //no compatible products
            return null; //bail
        }

        //second, get any product which is compatible with currently selected option(s)
        $j.each(fallback['option_labels'], function(key, value) {
            var image = value['configurable_product'][type];
            var products = value['products'];

            if(image) { //configurable product has image in the first place
                //if intersection between compatible products and this label's products, we found a match
                var isCompatibleProduct = ConfigurableMediaImages.arrayIntersect(products, compatibleProducts).length > 0;
                if(isCompatibleProduct) {
                    return image;
                }
            }
        });

        //third, get image off of child product which is compatible
        var childSwatchImage = null;
        var childProductImages = fallback[type];
        swapGallery = true;
        compatibleProducts.each(function(productId) {
            if(childProductImages[productId] && ConfigurableMediaImages.isValidImage(childProductImages[productId])) {
                childSwatchImage = childProductImages[productId];
                return false; //break "loop"
            }
        });
        if (childSwatchImage) {
            return childSwatchImage;
        }

        //fourth, get base image off parent product
        if (childProductImages[productId] && ConfigurableMediaImages.isValidImage(childProductImages[productId])) {
            return childProductImages[productId];
        }

        //no fallback image found
        return null;
    },

    getImageObject: function(productId, imageUrl) {
        var key = productId+'-'+imageUrl;
        if(!ConfigurableMediaImages.imageObjects[key]) {
            var image = $j('<img />');
            image.attr('src', imageUrl);
            ConfigurableMediaImages.imageObjects[key] = image;
        }
        return ConfigurableMediaImages.imageObjects[key];
    },

    updateImage: function(el) {
        var select = $j(el);
        var label = select.find('option:selected').attr('data-label');
        var productId = optionsPrice.productId; //get product ID from options price object

        //find all selected labels
        var selectedLabels = new Array();
        $j('.product-options .super-attribute-select').each(function() {
            var $option = $j(this);
            if($option.val() != '') {
                selectedLabels.push($option.find('option:selected').attr('data-label'));
            }
        });

        var swatchImageUrl = ConfigurableMediaImages.getSwatchImage(productId, label, selectedLabels, undefined);
        var swatchMediumImageUrl = ConfigurableMediaImages.getSwatchImage(productId, label, selectedLabels, 'medium_image');
        var swatchAdditionalImagesUrl = ConfigurableMediaImages.getSwatchImage(productId, label, selectedLabels, 'additional_images');
        if(!ConfigurableMediaImages.isValidImage(swatchImageUrl) &&
            !ConfigurableMediaImages.isValidImage(swatchMediumImageUrl)) {
            return;
        }

        var swatchImage = ConfigurableMediaImages.getImageObject(productId, swatchImageUrl);

        targetImage = $j(swatchImage);
        var imageGallery = $j('#gallery-image');
        var additionalImages = '',
            additionalImagesMobile = '';
            i = 1;
        if (swapGallery) {
            $j.each(swatchAdditionalImagesUrl['thumbnail'], function(index, url) {
                additionalImages += (i==1) ? '<li class="selected">' : '<li>';
                additionalImages += '<a class="lightbox" data-url-medium="'+
                    swatchAdditionalImagesUrl['medium_image'][index]+
                    '" href="'+swatchAdditionalImagesUrl['image'][index]+'" role="button">'+
                    '<img src="'+swatchAdditionalImagesUrl['thumbnail'][index]+
                    '" alt="" width="68" height="68"></a>'+
                    '<span class="a11y">Display Gallery Item '+i+'</span></li>';
                additionalImagesMobile += '<li class="item"><a class="lightbox-mobile" '+
                'href="'+swatchAdditionalImagesUrl['image'][index]+'">'+
                    '<img src="'+swatchAdditionalImagesUrl['medium_image'][index]+
                    '" alt="" width="400" height="400"></a></li>';
                i++;
            });
        }

        if(targetImage[0].complete) { //image already loaded -- swap immediately
            // change gallery image src attr
            imageGallery.children('img').attr("src", swatchMediumImageUrl);
            // change gallery image href attr
            imageGallery.attr('href', swatchImageUrl);
            // change additional images
            if (swapGallery) {
                $j('.more-views').html(additionalImages);
                $j('#gallery-image-mobile').children('.item').each(function(index){
                    $j(this).find('a').attr('href', swatchAdditionalImagesUrl['image'][index]);
                    $j(this).find('img').attr('src', swatchAdditionalImagesUrl['medium_image'][index]);
                });
            } else {
                $j('.more-views').addClass('no-swap');
            }
        } else { //need to wait for image to load
            //add spinner
            imageGallery.addClass('spinner');
            // change main image src attr
            imageGallery.children('img').attr('src', swatchMediumImageUrl);
            // change gallery image href attr
            imageGallery.attr('href', swatchImageUrl);
            if (swapGallery) {
                // change additional images
                $j('.more-views').html(additionalImages);
                $j('#gallery-image-mobile').children('.item').each(function(index){
                    $j(this).find('a').attr('href', swatchAdditionalImagesUrl['image'][index]);
                    $j(this).find('img').attr('src', swatchAdditionalImagesUrl['medium_image'][index]);
                });
            } else {
                $j('.more-views').addClass('no-swap');
            }
            //wait until image is loaded
            imagesLoaded(targetImage, function() {
            //remove spinner
            imageGallery.removeClass('spinner');
            });
        }
        lightboxInstance.updateTargets($j('.lightbox'));
        lightboxMobileInstance.updateTargets($j('.lightbox-mobile'));
    },

    wireOptions: function() {
        $j('.product-options .super-attribute-select').change(function(e) {
            ConfigurableMediaImages.updateImage(this);
        });
    },

    swapListImage: function(productId, imageObject) {
        var originalImage = $j('#product-collection-image-' + productId);

        if(imageObject[0].complete) { //swap image immediately

            //remove old image
            originalImage.addClass('hidden');
            $j('.product-collection-image-' + productId).remove();

            //add new image
            imageObject.insertAfter(originalImage);

        } else { //need to load image

            var wrapper = originalImage.parent();

            //add spinner
            wrapper.addClass('spinner');

            //wait until image is loaded
            imagesLoaded(imageObject, function() {
                //remove spinner
                wrapper.removeClass('spinner');

                //remove old image
                originalImage.addClass('hidden');
                $j('.product-collection-image-' + productId).remove();

                //add new image
                imageObject.insertAfter(originalImage);
            });

        }
    },

    swapListImageByOption: function(productId, optionLabel) {
        var swatchImageUrl = ConfigurableMediaImages.getSwatchImage(productId, optionLabel, [optionLabel], undefined);
        if(!swatchImageUrl) {
            return;
        }

        var newImage = ConfigurableMediaImages.getImageObject(productId, swatchImageUrl);
        newImage.addClass('product-collection-image-' + productId);

        ConfigurableMediaImages.swapListImage(productId, newImage);
    },

    setImageFallback: function(productId, imageFallback) {
        ConfigurableMediaImages.productImages[productId] = imageFallback;
    },

    init: function(imageType) {
        ConfigurableMediaImages.imageType = imageType;
        ConfigurableMediaImages.wireOptions();
    }
};
