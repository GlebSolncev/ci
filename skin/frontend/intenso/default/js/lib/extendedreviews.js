/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_ExtendedReviews
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

(function() {
    ExtendedReviews = {
        init: function() {
            $j('.summary-popover .rating-box').each(function(index,el) {
                $j(this).hoverIntent({
                    over: function(){
                        product = el.readAttribute('data-review-product');
                        url = el.readAttribute('data-review-url');
                        ExtendedReviews.showProductReviews(product, url, el.next());
                    },
                    out: function(){},
                    timeout: 100
                });

                $j('.item-content').each(function(index,el) { $j(this).on('mouseleave', function(event) {
                    event.preventDefault();
                    ExtendedReviews.hidePopover();
                })});
            });
            if (typeof viewMore !== 'undefined' && this.isArray(viewMore)) {
                for (i = 0; i < viewMore.length; ++i) {
                    this.viewMore(viewMore[i]);
                }
            }
        },
        isArray: function(obj) {
            return obj && obj.constructor == Array;
        },   
        viewMore: function(id) {
            var review = $j('.review-' + id);
                if (review && review.html()) {
                    var words = review.html().split(/[ ]+/);
                    if (words.length > viewMoreLimit) {
                        var counter = 0,
                            toHide = [],
                            toShow = [];
                        for (var i = 0; i < words.length; i++) {
                            if (counter >= viewMoreLimit) {
                                toHide.push(words[i]);
                            } else {
                                toShow.push(words[i]);
                            }
                            if (words[i].length > 1) {
                                counter++;
                            }
                        }
                        if (counter >= viewMoreLimit) {
                            var viewMoreLink = $j('<span id="view-more-'+id+'" class="view-more arrow-right">'+Translator.translate('View more')+'</span>');
                            var ellipsis = $j('<span class="ellipsis-'+id+'">... </span>');
                            var hide = $j('<span></span>');
                            hide.html(toHide.join(' '));
                            hide.addClass('view-more-' + id);
                            hide.hide();
                            review.html(toShow.join(' ') + ellipsis.prop('outerHTML') + viewMoreLink.prop('outerHTML') + ' ' + hide.prop('outerHTML'));
                            $j('#view-more-'+id).on('click', function(){
                                this.hide();
                                $j('.ellipsis-' + id).hide();
                                $j('.view-more-' + id).show();
                            });
                        }
                    }
                }
        },
        vote: function(url, review, vote) {
            if (url != undefined && review != undefined && vote != undefined) {
                var btn = $$('.helpful-buttons-' + review);
                new Ajax.Request(url, {
                    method: 'POST',
                    parameters: {review: review, helpful: vote},
                    onSuccess: function(response) {
                        if (response.responseText.length > 0) {
                            var r = JSON.parse(response.responseText);
                            if (r.vote) {
                                $$('.helpful-' + review).each(function(e) {
                                    e.update(r.msg);
                                    e.addClassName('review-' + r.vote);
                                });
                                $$('.helpful-button-' + review).each(function(e) {
                                    e.remove();
                                });
                            }
                        }

                    },
                    onCreate: function() {
                        btn.each(function(e) {
                            e.disabled = true;
                        });
                    }
                });
            }
        },
        postReview: function(form) {
            var body = $$('body').first();
            var obj = this;
            new Ajax.Request(form.action, {
                method: 'POST',
                parameters: form.serialize(),
                onSuccess: function(response) {
                    if (response.responseText.length > 0) {
                        var r = JSON.parse(response.responseText);
                        var revealMsg = '<div id="reveal-messages" class="reveal-modal" data-reveal>';
                        revealMsg += '<div class="close-reveal-modal"></div>';
                        revealMsg += r.msg;
                        revealMsg += '<div class="modal-action"><a class="button" onclick="jQuery(\'#reveal-messages\').foundation(\'reveal\', \'close\');">' + Translator.translate("Accept") +'</a></div>';
                        revealMsg += '</div>';
                        if (r.success) {
                            $('post-review').remove();
                        } else {
                            $('reveal-messages').remove();
                        }
                        body.insert({bottom: revealMsg});
                        setTimeout(function() { jQuery("#reveal-messages").foundation().foundation("reveal", "open") }, 300);
                    }
                }
            });
            return false;
        },
        checkFit: function(popover) {
            position = popover.viewportOffset();
            viewportWidth = $$('.inner-wrap')[0].getWidth();
            popoverWidth = parseInt(popover.getStyle('width'));
            margin = viewportWidth*3/100;
            if (viewportWidth - position.left < popoverWidth + margin) {
                popover.addClassName('move-popover');
                reference = popover.previous().viewportOffset();
                _left = -(popover.getWidth() + reference.left - viewportWidth + (margin/2));
                popover.setStyle({left: _left+'px'});
            }
        },
        showProductReviews: function(product, url, popover) {
            if (document.viewport.getWidth() / parseFloat($$('body')[0].getStyle("font-size")) <= 40) return;
            if (this.loadedReviews == undefined) {
                this.loadedReviews = [];
            }
            var el = this;
            if (this._documentClick == undefined || !this._documentClick) {
                document.observe('click', function(e) {
                    el.hidePopover(e);
                });
                this._documentClick = true;
            }
            this.hidePopover();
            this.checkFit(popover);

            if (this.loadedReviews[product]) {
                this.showLoadedReviews(this.loadedReviews[product], popover);
                popover.previous().addClassName('active');
            } else {
                popover.previous().firstDescendant('.summary-popover-icon').addClassName('spinner');
                new Ajax.Request(url, {
                    method: 'GET',
                    onSuccess: function(response) {
                        if (response.responseText.length > 0) {
                            el.loadedReviews[product] = response.responseText;
                            el.showLoadedReviews(el.loadedReviews[product], popover);
                            popover.previous().addClassName('active');
                            popover.previous().firstDescendant('.summary-popover-icon').removeClassName('spinner');
                        }
                    }
                });
            }
        },
        showLoadedReviews: function(reviews, popover) {
            if (reviews) {
                popover.update(reviews);
                popover.select('.review-close').first().onclick = function() {
                    popover.select('.review-popover').first().hide();
                    popover.previous().removeClassName('active');
                };
                popover.show();
            } else {
                popover.update('');
                popover.hide();
            }
        },
        hidePopover: function(e) {
            if (e) {
                var e = e.toElement || e.target;
                if (e.className == 'summary-popover' || e.up('.summary-popover')) {
                    return;
                }
            }
            $$('.review-popover').each(function(i) {
                i.hide();
            });
            $$('.summary-popover-content').each(function(el) {
                el.removeClassName('move-popover');
                el.setStyle({left: ''});
                el.previous().removeClassName('active');
            });
        },
        showComments: function(commentsUrl, reviewId) {
            if (this.loadedComments == undefined) {
                this.loadedComments = [];
            }
            var that = this;
            if (typeof this.loadedComments[reviewId] != 'undefined') {
                $$('.comments-wrapper-' + reviewId).each(function(el) {
                    el.update(that.loadedComments[reviewId]);
                });
                return false;
            }
            new Ajax.Request(commentsUrl, {
                method: 'GET',
                onSuccess: function(response) {
                    if (response.responseText.length > 0) {
                        $$('.comments-wrapper-' + reviewId).each(function(el) {
                            el.update(response.responseText);
                            that.loadedComments[reviewId] = response.responseText;
                        });
                    }
                }
            });
            return false;
        },
        hideComments: function(reviewId) {
            $$('.comments-wrapper-' + reviewId).each(function(el) {
                el.update('');
            });
        },
        showAddCommentForm: function(url, reviewId) {
            var that = this;
            new Ajax.Request(url, {
                method: 'GET',
                onSuccess: function(response) {
                    if (response.responseText.length > 0) {
                        $$('.comments-wrapper-' + reviewId).each(function(el) {
                            that._processCommentForm(el, response.responseText, reviewId);
                        });
                    }
                }
            });
            return false;
        },
        _submitComment: function(form, reviewId) {
            var that = this;
            new Ajax.Request(form.action, {
                method: 'POST',
                parameters: form.serialize(),
                onSuccess: function(response) {
                    if (response.responseText.length > 0) {
                        $$('.comments-wrapper-' + reviewId).each(function(el) {
                            var data = JSON.parse(response.responseText);
                            if (data.success) {
                                el.update(data.msg);
                                el.addClassName('comment-success')
                            } else {
                                var cnt = form.up();
                                cnt.insert({top: data.msg});
                            }
                        });
                    }
                }
            });
            return false;
        },
        _processCommentForm: function(cnt, response, reviewId) {
            var data = JSON.parse(response);
            var o = this;
            if (data && data.content != undefined) {
                if (!o._forms) {
                    o._forms = {};
                }
                cnt.update(data.content);
                var form = cnt.select('form').first();
                if (o._forms[reviewId] != undefined) {
                    delete o._forms[reviewId];
                }
                o._forms[reviewId] = new VarienForm(form);
                o._forms[reviewId].submit = function(button) {
                    if (this.validator && this.validator.validate()) {
                        o._submitComment(form, reviewId);
                    }
                    return false;
                }.bind(o._forms[reviewId]);
                var btn = form.select('button').first();
                if (btn) {
                    btn.setAttribute('onclick', 'ExtendedReviews._forms[' + reviewId + '].submit();return false;');
                }
            }
        }
    };
    ExtendedReviews.init();
    document.observe('catalog:update', function() {
        ExtendedReviews.init();
    });
})();