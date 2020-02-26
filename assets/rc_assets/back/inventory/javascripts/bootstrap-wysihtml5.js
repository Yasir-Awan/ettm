
!function($, wysi) {
    "use strict";

    var tpl = {
        "font-sizes": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li class='dropdown'>" +
              "<a class='btn dropdown-toggle" + size + "' data-toggle='dropdown' href='#'>" +
              "<i class='icon-font'></i>&nbsp;<span class='current-font-size'>" + locale.font_sizes.normal + "</span>&nbsp;<b class='caret'></b>" +
              "</a>" +
              "<ul class='dropdown-menu'>" +
                "<li><a data-wysihtml5-command='fontSize' data-wysihtml5-command-value='normal' tabindex='-1'>" + locale.font_sizes.normal + "</a></li>" +
                "<li><a data-wysihtml5-command='fontSize' data-wysihtml5-command-value='xx-small' tabindex='-1'>" + locale.font_sizes.xxSmall + "</a></li>" +
                "<li><a data-wysihtml5-command='fontSize' data-wysihtml5-command-value='x-small' tabindex='-1'>" + locale.font_sizes.xsmall + "</a></li>" +
                "<li><a data-wysihtml5-command='fontSize' data-wysihtml5-command-value='small' tabindex='-1'>" + locale.font_sizes.small + "</a></li>" +
                "<li><a data-wysihtml5-command='fontSize' data-wysihtml5-command-value='medium' tabindex='-1'>" + locale.font_sizes.medium + "</a></li>" +
                "<li><a data-wysihtml5-command='fontSize' data-wysihtml5-command-value='large'>" + locale.font_sizes.large + "</a></li>" +
                "<li><a data-wysihtml5-command='fontSize' data-wysihtml5-command-value='x-large'>" + locale.font_sizes.xLarge + "</a></li>" +
                "<li><a data-wysihtml5-command='fontSize' data-wysihtml5-command-value='xx-large'>" + locale.font_sizes.xxLarge + "</a></li>" +
                "<li><a data-wysihtml5-command='fontSize' data-wysihtml5-command-value='larger'>" + locale.font_sizes.larger + "</a></li>" +
              "</ul>" +
            "</li>";
        },
        "font-styles": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li class='dropdown'>" +
              "<a class='btn dropdown-toggle" + size + "' data-toggle='dropdown' href='#'>" +
              "<i class='icon-font'></i>&nbsp;<span class='current-font'>" + locale.font_styles.normal + "</span>&nbsp;<b class='caret'></b>" +
              "</a>" +
              "<ul class='dropdown-menu'>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='div' tabindex='-1'>" + locale.font_styles.normal + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h1' tabindex='-1'>" + locale.font_styles.h1 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h2' tabindex='-1'>" + locale.font_styles.h2 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h3' tabindex='-1'>" + locale.font_styles.h3 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h4'>" + locale.font_styles.h4 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h5'>" + locale.font_styles.h5 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h6'>" + locale.font_styles.h6 + "</a></li>" +
              "</ul>" +
            "</li>";
        },

        "emphasis": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='btn-group'>" +
                "<a class='btn" + size + "' data-wysihtml5-command='bold' title='CTRL+B' tabindex='-1'>" + locale.emphasis.bold + "</a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='italic' title='CTRL+I' tabindex='-1'>" + locale.emphasis.italic + "</a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='underline' title='CTRL+U' tabindex='-1'>" + locale.emphasis.underline + "</a>" +
              "</div>" +
            "</li>";
        },

        "lists": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='btn-group'>" +
                "<a class='btn" + size + "' data-wysihtml5-command='insertUnorderedList' title='" + locale.lists.unordered + "' tabindex='-1'><i class='icon-list'></i></a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='insertOrderedList' title='" + locale.lists.ordered + "' tabindex='-1'><i class='icon-th-list'></i></a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='Outdent' title='" + locale.lists.outdent + "' tabindex='-1'><i class='icon-indent-right'></i></a>" +
                "<a class='btn" + size + "' data-wysihtml5-command='Indent' title='" + locale.lists.indent + "' tabindex='-1'><i class='icon-indent-left'></i></a>" +
              "</div>" +
            "</li>";
        },

        "link": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='bootstrap-wysihtml5-insert-link-modal modal hide fade'>" +
                "<div class='modal-header'>" +
                  "<a class='close' data-dismiss='modal'>&times;</a>" +
                  "<h3>" + locale.link.insert + "</h3>" +
                "</div>" +
                "<div class='modal-body'>" +
                  "<div>" +
                    "<label for='insert_link_text' class='inline span2 margin-left-reset margin-top-5'>Text: </label>" +
                    "<input type='text' id='insert_link_text' class='span3 inline'>" +
                  "</div>" +
                  "<div>" +
                    "<label for='insert_link_url' class='inline span2 margin-left-reset margin-top-5'>URL: </label>" +
                    "<input value='http://' id='insert_link_url' class='bootstrap-wysihtml5-insert-link-url span3 inline'>" +
                  "</div>" +
                  "<label class='checkbox margin-top-5'> <input type='checkbox' class='bootstrap-wysihtml5-insert-link-target undo-bootstrap-hack' checked>" + locale.link.target + "</label>" +
                "</div>" +
                "<div class='modal-footer'>" +
                  "<a href='#' class='btn' data-dismiss='modal'>" + locale.link.cancel + "</a>" +
                  "<a href='#' class='btn btn-primary' data-dismiss='modal'>" + locale.link.insert + "</a>" +
                "</div>" +
              "</div>" +
              "<a class='btn" + size + "' data-wysihtml5-command='createLink' title='" + locale.link.insert + "' tabindex='-1'><i class='icon-share'></i></a>" +
            "</li>";
        },

        "mailto": function(locale, options) {
          var size = (options && options.size) ? ' btn-'+options.size : '';
          return "<li>" +
            "<div class='bootstrap-wysihtml5-insert-mailto-modal modal hide fade'>" +
              "<div class='modal-header'>" +
                "<a class='close' data-dismiss='modal'>&times;</a>" +
                "<h3>" + locale.mailto.insert + "</h3>" +
              "</div>" +
              "<div class='modal-body'>" +
                "<input value='mailto:' class='bootstrap-wysihtml5-insert-mailto-link input-xlarge'>" +
              "</div>" +
              "<div class='modal-footer'>" +
                "<a href='#' class='btn' data-dismiss='modal'>" + locale.mailto.cancel + "</a>" +
                "<a href='#' class='btn btn-primary' data-dismiss='modal'>" + locale.mailto.insert + "</a>" +
              "</div>" +
            "</div>" +
            "<a class='btn" + size + "' data-wysihtml5-command='createMailto' title='" + locale.mailto.insert + "' tabindex='-1'><i class='icon-envelope'></i></a>" +
          "</li>";
        },

        "image": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='bootstrap-wysihtml5-insert-image-modal modal hide fade'>" +
                "<div class='modal-header'>" +
                  "<a class='close' data-dismiss='modal'>&times;</a>" +
                  "<h3>" + locale.image.insert + "</h3>" +
                "</div>" +
                "<div class='modal-body'>" +
                  "<input value='http://' class='bootstrap-wysihtml5-insert-image-url input-xlarge'>" +
                "</div>" +
                "<div class='modal-footer'>" +
                  "<a href='#' class='btn' data-dismiss='modal'>" + locale.image.cancel + "</a>" +
                  "<a href='#' class='btn btn-primary' data-dismiss='modal'>" + locale.image.insert + "</a>" +
                "</div>" +
              "</div>" +
              "<a class='btn" + size + "' data-wysihtml5-command='insertImage' title='" + locale.image.insert + "' tabindex='-1'><i class='icon-picture'></i></a>" +
            "</li>";
        },

        "placeholders": function(locale, options){
            var size = (options && options.size) ? ' btn-' + options.size : '';
            return "<li>" +
              "<div class='bootstrap-wysihtml5-insert-placeholder-modal modal hide fade'>" +
                "<div class='modal-header'>" +
                  "<a class='close' data-dismiss='modal'>&times;</a>" +
                  "<h3>" + locale.placeholder.insert + "</h3>" +
                "</div>" +
                "<div class='modal-body'>" +
                  "<div id='placeholder-links'></div>" +
                "</div>" +
                "<div class='modal-footer'>" +
                  "<a href='#' class='btn' data-dismiss='modal'>" + locale.placeholder.cancel + "</a>" +
                "</div>" +
              "</div>" +
              "<a class='btn" + size + "' data-wysihtml5-command='insertPlaceholder' title='" + locale.placeholder.insert + "' tabindex='-1'>Placeholder</a>" +
            "</li>";
        },

        "paymentlink": function(locale, options){
            return "";
        },

        "orderTemplatePublicLink": function(locale, options) {
          return "";
        },
        "orderPrintoutTemplateLink": function(locale, options) {
          return "";
        },

        "orderImageLink": function(locale, options) {
          var size = (options && options.size) ? ' btn-' + options.size : '';
          return "<li>" +
            "<a class='btn attachImageBtn" + size + "' data-prefix='" +options['prefix']+ "' data-wysihtml5-command='insertImage' title='" + locale.image.insert + "' id='attachImage'><i class='fa fa-lg fa-paperclip'></i></a>" +
          "</li>";
        },



        "html": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
              "<div class='btn-group'>" +
                "<a class='btn" + size + "' data-wysihtml5-action='change_view' title='" + locale.html.edit + "' tabindex='-1'><i class='icon-pencil'></i></a>" +
              "</div>" +
            "</li>";
        },

        "color": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li class='dropdown'>" +
              "<a class='btn dropdown-toggle" + size + "' data-toggle='dropdown' href='#' tabindex='-1'>" +
                "<span class='current-color'>" + locale.colours.black + "</span>&nbsp;<b class='caret'></b>" +
              "</a>" +
              "<ul class='dropdown-menu'>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='black'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='black'>" + locale.colours.black + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='silver'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='silver'>" + locale.colours.silver + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='gray'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='gray'>" + locale.colours.gray + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='maroon'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='maroon'>" + locale.colours.maroon + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='red'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='red'>" + locale.colours.red + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='purple'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='purple'>" + locale.colours.purple + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='green'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='green'>" + locale.colours.green + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='olive'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='olive'>" + locale.colours.olive + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='navy'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='navy'>" + locale.colours.navy + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='blue'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='blue'>" + locale.colours.blue + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='orange'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='orange'>" + locale.colours.orange + "</a></li>" +
              "</ul>" +
            "</li>";
        }
    };

    var templates = function(key, locale, options) {
        return tpl[key](locale, options);
    };

    var insertPrintOrderPDF = function(printOrderTypeDom, printOrderTemplateDom, insertPrintOrderDom, formId) {
      if (printOrderTypeDom.val()) {
        var templateType      = printOrderTypeDom.find(':selected').val();
        var templateId        = printOrderTemplateDom.find(':selected').val();
        var templateName      = printOrderTemplateDom.find(':selected').html();
        var key               = parseInt($('#attachments_id_counter').val()) + 1;
        var templateTypeName  = printOrderTypeDom.find(':selected').text();
        var input             = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "attachments[]");
        input.setAttribute("id", key + 'attachment');
        input.setAttribute("value", templateType + ',' + templateId);
        document.getElementById(formId).appendChild(input);
        var removeLink = document.createElement("a");
        removeLink.setAttribute("data-value", key);
        var linkText = document.createTextNode("X");
        removeLink.appendChild(linkText);
        removeLink.addEventListener("click",function(){
          var attachmentId = $(this).data("value");
          $('#' + attachmentId).remove();
          $('#' + attachmentId + 'attachment').remove();
          $('#attachments-section').toggle($("#attachments-section").children().length > 1);
        },false);
        $('#attachments_id_counter').val(key);
        var attachmentView = document.createElement("div");
        attachmentView.setAttribute("id", key);
        attachmentView.appendChild(removeLink);
        var attachmentText = document.createTextNode("  " + templateTypeName + " - " + templateName);
        attachmentView.appendChild(attachmentText);
        if (printOrderTemplateDom.find(':selected').data('sigpad')) {
          var warningSpan = document.createElement("span");
          var warningText = document.createTextNode("(Signature Pad requires sending this as a link)");
          warningSpan.appendChild(warningText);
          warningSpan.setAttribute("class", 'required');
          attachmentView.appendChild(warningSpan);
        }
        $('#attachments-section').append(attachmentView);
        $('#attachments-section').toggle($("#attachments-section").children().length > 1);
      }
    };

    var Wysihtml5 = function(el, options) {
        this.el = el;
        var toolbarOpts = options || defaultOptions;
        for(var t in toolbarOpts.customTemplates) {
          tpl[t] = toolbarOpts.customTemplates[t];
        }
        this.toolbar = this.createToolbar(el, toolbarOpts);
        this.editor =  this.createEditor(options);

        window.editor = this.editor;

        $('iframe.wysihtml5-sandbox').each(function(i, el){
            $(el.contentWindow).off('focus.wysihtml5').on({
                'focus.wysihtml5' : function(){
                    $('li.dropdown').removeClass('open');
                }
            });
        });
    };

    Wysihtml5.prototype = {

        constructor: Wysihtml5,

        createEditor: function(options) {
            options = options || {};
            
            // Add the toolbar to a clone of the options object so multiple instances
            // of the WYISYWG don't break because "toolbar" is already defined
            options = $.extend(true, {}, options);
            options.toolbar = this.toolbar[0];

            var editor = new wysi.Editor(this.el[0], options);

            if(options && options.events) {
                for(var eventName in options.events) {
                    editor.on(eventName, options.events[eventName]);
                }
            }
            return editor;
        },

        createToolbar: function(el, options) {
            var self = this;
            var toolbar = $("<ul/>", {
                'class' : "wysihtml5-toolbar",
                'style': "display:none"
            });
            var culture = options.locale || defaultOptions.locale || "en";
            for(var key in defaultOptions) {
                var value = false;

                if(options[key] !== undefined) {
                    if(options[key] === true) {
                        value = true;
                    }
                } else {
                    value = defaultOptions[key];
                }

                if(value === true) {
                    toolbar.append(templates(key, locale[culture], options));

                    if(key === "html") {
                        this.initHtml(toolbar);
                    }

                    if(key === "link") {
                        this.initInsertLink(toolbar);
                    }

                    if(key === "image") {
                        this.initInsertImage(toolbar);
                    }

                    if(key === "placeholders") {
                        this.initInsertPlaceholder(toolbar, options["template_selector"]);
                    }

                    if(key === 'paymentlink'){
                        this.initInsertPaymentLink(toolbar);
                    }

                    if(key === 'orderTemplatePublicLink') {
                      this.initInsertOrderTemplatePublicLink(toolbar);
                    }

                    if(key === 'orderPrintoutTemplateLink') {
                      this.initInsertOrderPrintoutTemplateLink(toolbar);
                    }

                    if(key === 'orderImageLink') {
                      this.initOrderImageLink(toolbar)
                    }

                    if(key === "mailto") {
                      this.initInsertMailto(toolbar);
                    }
                }
            }

            if(options.toolbar) {
                for(key in options.toolbar) {
                    toolbar.append(options.toolbar[key]);
                }
            }

           toolbar.find("a[data-wysihtml5-command='fontSize']").click(function(e) {
                var target = e.target || e.srcElement;
                var el = $(target);
                self.toolbar.find('.current-font-size').text(el.html());
            });

            toolbar.find("a[data-wysihtml5-command='formatBlock']").click(function(e) {
                var target = e.target || e.srcElement;
                var el = $(target);
                self.toolbar.find('.current-font').text(el.html());
            });

            toolbar.find("a[data-wysihtml5-command='foreColor']").click(function(e) {
                var target = e.target || e.srcElement;
                var el = $(target);
                self.toolbar.find('.current-color').text(el.html());
            });
            $("#attachments-section").toggle($("#attachments-section").children().length > 1);
            $("#"+options['prefix']+"attachments-section").toggle($("#"+options['prefix']+"attachments-section").children().length > 1);

            this.el.before(toolbar);

            return toolbar;
        },

        initHtml: function(toolbar) {
            var changeViewSelector = "a[data-wysihtml5-action='change_view']";
            toolbar.find(changeViewSelector).click(function(e) {
                toolbar.find('a.btn').not(changeViewSelector).toggleClass('disabled');
            });
        },

        initInsertImage: function(toolbar) {
            var self = this;
            var insertImageModal = toolbar.find('.bootstrap-wysihtml5-insert-image-modal');
            var urlInput = insertImageModal.find('.bootstrap-wysihtml5-insert-image-url');
            var insertButton = insertImageModal.find('a.btn-primary');
            var initialValue = urlInput.val();
            var caretBookmark;

            var insertImage = function() {
                var url = urlInput.val();
                urlInput.val(initialValue);
                self.editor.currentView.element.focus();
                if (caretBookmark) {
                  self.editor.composer.selection.setBookmark(caretBookmark);
                  caretBookmark = null;
                }
                self.editor.composer.commands.exec("insertImage", url);
            };

            urlInput.keypress(function(e) {
                if(e.which == 13) {
                    insertImage();
                    insertImageModal.modal('hide');
                }
            });

            insertButton.click(insertImage);

            insertImageModal.on('shown', function() {
                urlInput.focus();
            });

            insertImageModal.on('hide', function() {
                self.editor.currentView.element.focus();
            });

            toolbar.find('a[data-wysihtml5-command=insertImage]').click(function() {
                var activeButton = $(this).hasClass("wysihtml5-command-active");

                if (!activeButton) {
                    self.editor.currentView.element.focus();
                    caretBookmark = self.editor.composer.selection.getBookmark();
                    insertImageModal.appendTo('body').modal('show');
                    insertImageModal.on('click.dismiss.modal', '[data-dismiss="modal"]', function(e) {
                        e.stopPropagation();
                    });

                    return false;
                }
                else {
                    return true;
                }
            });
        },

        initInsertPlaceholder: function(toolbar, template_selector) {
            var self = this;
            var insertPlaceholderModal = toolbar.find('.bootstrap-wysihtml5-insert-placeholder-modal');
            var caretBookmark;

            var insertPlaceholder = function() {
                self.editor.currentView.element.focus();
                if (caretBookmark) {
                  self.editor.composer.selection.setBookmark(caretBookmark);
                  caretBookmark = null;
                }

                self.editor.composer.commands.exec("insertPlaceholder", { value: $(this).data('link-placeholder') });
                insertPlaceholderModal.modal('hide');
            };

            var showRequiredPlaceholdersHelp = function(){
                if(typeof required_placeholders != "undefined"){
                  var req_placeholders = required_placeholders[$('#email_template_template_type').val()];
                  console.log(req_placeholders);
                  if(req_placeholders !== undefined && req_placeholders.length > 0){
                      var help_html = '<ul>';
                      $.each(req_placeholders, function(index, value){
                          help_html += '<li>' + $.titleize(value) + '</li>';
                      });
                      help_html += '</ul>';
                      $('div#required_placeholders_help #placeholders').html(help_html);
                      $('div#required_placeholders_help').show();
                  }
                  else{
                      $('div#required_placeholders_help #placeholders').html('');
                      $('div#required_placeholders_help').hide();
                  }
                }
            }

            var bindPlaceholderLinks = function() {
                if(window.bindEvent){
                    insertPlaceholderModal.on('shown', function(){
                        $('.allowed_placeholder').bind('click', insertPlaceholder);
                        window.bindEvent = false;
                    });
                    insertPlaceholderModal.on('hidden', function(){
                        $('.allowed_placeholder').unbind('click', insertPlaceholder);
                    });
                }
            }

            var setPreviousTemplateType = function(){
                window.previous_template_type = $(this).find(':selected').val();
            }

            var removePlaceholders = function(){
                showRequiredPlaceholdersHelp();
                var selectedTemplate = $(this).find(':selected').val();
                self.editor.composer.commands.exec("removePlaceholders", selectedTemplate);
                showHideAttachPrintoutDivInEmail(selectedTemplate);
            };
            var showHideAttachPrintoutDivInEmail = function(selectedTemplate) {
                var attachPrintout = $('#attach_printout_in_email_template');
                if(attachPrintout !== undefined && attachPrintout.length > 0) {
                    var attachPrintoutAlerts = getGlobalData('attach_prinout_alerts');
                    if(attachPrintoutAlerts.indexOf(selectedTemplate) != -1) {
                        $('#attach_printout_in_email_template').show();
                        $('#attachments-section').show();
                    }
                    else {
                        $('#email_template_attach_printout_in_order_alerts').attr('checked', false);
                        $('#attach_printout_in_email_template').hide();
                        $('#attachments-section').hide();
                    }
                }
            };

            insertPlaceholderModal.on('hide', function() {
                self.editor.currentView.element.focus();
            });

            $('#email_template_template_type').on('change', removePlaceholders);
            $('#email_template_template_type').on('focus', setPreviousTemplateType);
            showRequiredPlaceholdersHelp();

            toolbar.find('a[data-wysihtml5-command=insertPlaceholder]').click(function() {
                var activeButton = $(this).hasClass("wysihtml5-command-active");

                if (!activeButton) {
                    // self.editor.currentView.element.focus(false);
                    caretBookmark = self.editor.composer.selection.getBookmark();
                    insertPlaceholderModal.find('#placeholder-links').html($.allowed_placeholder_links($(template_selector).val()));
                    bindPlaceholderLinks();
                    insertPlaceholderModal.appendTo('body').modal('show');
                    insertPlaceholderModal.on('click.dismiss.modal', '[data-dismiss="modal"]', function(e) {
                        e.stopPropagation();
                    });
                    return false;
                }
                else {
                    return true;
                }
            });
        },

        initInsertPaymentLink: function(toolbar) {
            var self = this;
            var caretBookmark;

            var insertPaymentLink = function() {
                self.editor.currentView.element.focus();
                if (caretBookmark) {
                  self.editor.composer.selection.setBookmark(caretBookmark);
                  caretBookmark = null;
                }

                self.editor.composer.commands.exec("insertPaymentLink", { value: payment_note });
            };

            $('#request_customer_prepayment').on('click', function() {
                if($(this).is(':checked')){
                    insertPaymentLink();
                }
                else{
                    removePaymentLink();
                }
            });
        },

        initOrderImageLink: function(toolbar) {
          $('body').on('click', ".attachImageBtn", function(e){
            e.preventDefault();
            var prefix = $(this).data('prefix');
            $('#' +prefix+ 'attach_image_dialog').modal('show');
            $('#' +prefix+ 'attach_image_dialog').css("z-index", "1500");
          });

          $('body').on('click', ".attach_email_document_values", function(e){
            e.preventDefault();
            var prefix = $(this).data('prefix');
            $('#' +prefix+ 'attach_image_dialog').modal('hide');
            $('.' +prefix+ 'removeDocuments').remove();
            $('.' +prefix+ 'removeDocument').remove();
            var selectedDocuments = [];
            var selectedTable;
            if ($('table.Basket').length > 0) {
              selectedTable = $('table.' + prefix + 'Basket .selected_document_checkbox:checked');
            } else {
              selectedTable = $('table.' + prefix + 'Purchase.Order .selected_document_checkbox:checked');
            }
            selectedTable.each(function(){
              var key               = parseInt($('#' +prefix+ 'attachments_id_counter').val()) + 1;
              var input             = document.createElement("input");
              input.setAttribute("type", "hidden");
              input.setAttribute("name", "document_attachments[]");
              input.setAttribute("id", key + 'attachment');
              input.setAttribute("class", prefix+'removeDocuments')
              input.setAttribute("value", $(this).val());

              document.getElementById(prefix + "send-email-form").appendChild(input);
              var removeLink = document.createElement("a");
              removeLink.setAttribute("data-value", key);
              var linkText = document.createTextNode("X");
              removeLink.appendChild(linkText);
              removeLink.addEventListener("click",function(){
                var attachmentId = $(this).data("value");
                $('#' + attachmentId).remove();
                $('#' + attachmentId + 'attachment').remove();
                $('#' +prefix+ 'attachments-section').toggle($("#" +prefix+ "attachments-section").children().length > 1);
              },false);
              $('#' +prefix+ 'attachments_id_counter').val(key);
              var attachmentView = document.createElement("div");
              attachmentView.setAttribute("id", key);
              attachmentView.setAttribute("class", prefix+'removeDocument');
              attachmentView.appendChild(removeLink);
              var attachmentText = document.createTextNode(" " + $(this).data('document-name'));
              attachmentView.appendChild(attachmentText);
              $('#' +prefix+ 'attachments-section').append(attachmentView);
              $('#' +prefix+ 'attachments-section').toggle($("#" +prefix+ "attachments-section").children().length > 1);
            });
          });
        },

        initInsertOrderTemplatePublicLink: function(toolbar) {
          var self = this;
          var caretBookmark;
          var insertPrintOrderLink = function() {
            self.editor.currentView.element.focus();
            if (caretBookmark) {
              self.editor.composer.selection.setBookmark(caretBookmark);
              caretBookmark = null;
            }

            var printOrderTypeDom     = $('#template_type_for_email');
            var printOrderTemplateDom = $('#templates_list_for_email');
            var insertPrintOrderDom   = $('#insert-print-order-email');

            if (printOrderTypeDom.val()) {
              var templateType = printOrderTypeDom.find(':selected').val();
              var templateId   = printOrderTemplateDom.find(':selected').val();
              var basketId     = insertPrintOrderDom.data('basketId');
              var publicUrl    = location.protocol + '//' + location.host + '/' + 'basket_invoice' + '?code=' +
                insertPrintOrderDom.data('secureCode') + "&template_type=" +
                templateType + "&template_id=" + templateId + "&basket_id=" + basketId;

              var publicUrlLinkText = "Click HERE to view ";
              var templateTypeName  = printOrderTypeDom.find(':selected').text();
              if (templateTypeName == 'Other'){
                publicUrlLinkText += "Document";
              }
              else{
                publicUrlLinkText += templateTypeName;
              }

              var printOrderMessage = '<a href="' + publicUrl + '">' + publicUrlLinkText + '</a>';
              printOrderMessage    += " for " + insertPrintOrderDom.data('basket-num-with-label');
              if (printOrderTemplateDom.find(':selected').data('sigpad')) {
                printOrderMessage  += " to review and sign";
              }
              printOrderMessage    += ".";

              self.editor.composer.commands.exec("insertPaymentLink", { value: printOrderMessage });
            }
          };

          $('#insert-print-order-email').on('click', function() {
            insertPrintOrderLink();
          });

          $('#insert-pdf-print-order-email').on('click', function() {
            var printOrderTypeDom     = $('#template_type_for_email');
            var printOrderTemplateDom = $('#templates_list_for_email');
            var insertPrintOrderDom   = $('#insert-print-order-email');
            insertPrintOrderPDF(printOrderTypeDom, printOrderTemplateDom, insertPrintOrderDom, "send-email-form");
          });

          var insertPurchaseOrderLink = function() {
            self.editor.currentView.element.focus();
            if (caretBookmark) {
              self.editor.composer.selection.setBookmark(caretBookmark);
              caretBookmark = null;
            }

            var insertPurchaseOrderDom   = $('#insert-purchase-order-email');
            var poUrl    = location.protocol + '//' + location.host + '/purchase_orders/' + insertPurchaseOrderDom.data('purchase-order-id');
            var publicUrlLinkText = "Here is the link"

            var printOrderMessage = '<a href="' + poUrl + '">' + publicUrlLinkText + '</a>';
            printOrderMessage    += " to Purchase Order # " + insertPurchaseOrderDom.data('purchase-order-id') + " for you to review";
            self.editor.composer.commands.exec("insertPaymentLink", { value: printOrderMessage });
          };

          $('#insert-purchase-order-email').on('click', function() {
            insertPurchaseOrderLink();
          });
        },

        initInsertOrderPrintoutTemplateLink: function(toolbar) {
          var self = this;
          var caretBookmark;

          var insertPrintoutOrderTemplateLink = function() {
            self.editor.currentView.element.focus();
            if (caretBookmark) {
              self.editor.composer.selection.setBookmark(caretBookmark);
              caretBookmark = null;
            }

            var hasSignPad = $('#order_printout_template_type option:selected').data('sigpad');
            var printoutText = 'Review ';
            if(hasSignPad) {
              printoutText += 'and sign ';
            }
            printoutText += 'Order {{order_number_with_link}} by clicking {{order_template_link}}';
            self.editor.composer.commands.exec('insertCustomText', { value: printoutText });
          };

          $('#insert-printout-template-in-order-email').on('click', function() {
            insertPrintoutOrderTemplateLink();
          });

          $('#insert-printout-template-pdf-in-order-email').on('click', function() {
            var printOrderTypeDom     = $('#email_template_printout_template_type');
            var printOrderTemplateDom = $('#order_printout_template_dropdown');
            var insertPrintOrderDom   = $('#insert-print-order-email');
            insertPrintOrderPDF(printOrderTypeDom, printOrderTemplateDom, insertPrintOrderDom, 'email-template-dialog');
          });
        },

        initInsertMailto: function(toolbar) {
          var self = this;
          var insertMailToModal = toolbar.find('.bootstrap-wysihtml5-insert-mailto-modal');
          var urlInput = insertMailToModal.find('.bootstrap-wysihtml5-insert-mailto-link');
          var insertButton = insertMailToModal.find('a.btn-primary');
          var initialValue = urlInput.val();
          var caretBookmark;

          var insertMailTo = function() {
            var url = urlInput.val();
            urlInput.val(initialValue);
            self.editor.currentView.element.focus();
            if (caretBookmark) {
              self.editor.composer.selection.setBookmark(caretBookmark);
              caretBookmark = null;
            }

            self.editor.composer.commands.exec("createLink", { href: url });
          };
          var pressedEnter = false;

          urlInput.keypress(function(e) {
            if(e.which == 13) {
              insertMailTo();
              insertMailToModal.modal('hide');
            }
          });

          insertButton.click(insertMailTo);

          insertMailToModal.on('shown', function() {
            urlInput.focus();
          });

          insertMailToModal.on('hide', function() {
            self.editor.currentView.element.focus();
          });

          toolbar.find('a[data-wysihtml5-command=createMailto]').click(function() {
            var activeButton = $(this).hasClass("wysihtml5-command-active");

            if (!activeButton) {
              self.editor.currentView.element.focus();
              caretBookmark = self.editor.composer.selection.getBookmark();
              insertMailToModal.appendTo('body').modal('show');
              insertMailToModal.on('click.dismiss.modal', '[data-dismiss="modal"]', function(e) {
                e.stopPropagation();
              });
              return false;
            }
            else {
              return true;
            }
          });
        },

        initInsertLink: function(toolbar) {
            var self            = this;
            var insertLinkModal = toolbar.find('.bootstrap-wysihtml5-insert-link-modal');
            var urlTextInput    = insertLinkModal.find('#insert_link_text');
            var urlInput        = insertLinkModal.find('.bootstrap-wysihtml5-insert-link-url');
            var targetInput     = insertLinkModal.find('.bootstrap-wysihtml5-insert-link-target');
            var insertButton    = insertLinkModal.find('a.btn-primary');
            var initialValue    = urlInput.val();
            var caretBookmark;

            var insertLink = function() {
                var url = urlInput.val();
                urlInput.val(initialValue);
                self.editor.currentView.element.focus();
                if (caretBookmark) {
                  self.editor.composer.selection.setBookmark(caretBookmark);
                  caretBookmark = null;
                }

                var newWindow = targetInput.prop("checked");
                self.editor.composer.commands.exec("createLink", {
                    'href'   : url,
                    'text'   : urlTextInput.val(),
                    'target' : (newWindow ? '_blank' : '_self'),
                    'rel'    : (newWindow ? 'nofollow' : '')
                });
            };
            var pressedEnter = false;

            urlInput.keypress(function(e) {
                if(e.which == 13) {
                    insertLink();
                    insertLinkModal.modal('hide');
                }
            });

            insertButton.click(insertLink);

            insertLinkModal.on('shown', function() {
                urlInput.focus();
            });

            insertLinkModal.on('hide', function() {
                self.editor.currentView.element.focus();
            });

            toolbar.find('a[data-wysihtml5-command=createLink]').click(function() {
                var activeButton = $(this).hasClass("wysihtml5-command-active");

                if (!activeButton) {
                    self.editor.currentView.element.focus();
                    urlTextInput.val(self.editor.composer.selection.getRange().toString());
                    caretBookmark = self.editor.composer.selection.getBookmark();
                    insertLinkModal.appendTo('body').modal('show');
                    insertLinkModal.on('click.dismiss.modal', '[data-dismiss="modal"]', function(e) {
                        e.stopPropagation();
                    });
                    return false;
                }
                else {
                    return true;
                }
            });
        }
    };

    // these define our public api
    var methods = {
        resetDefaults: function() {
            $.fn.wysihtml5.defaultOptions = $.extend(true, {}, $.fn.wysihtml5.defaultOptionsCache);
        },
        bypassDefaults: function(options) {
            return this.each(function () {
                var $this = $(this);
                $this.data('wysihtml5', new Wysihtml5($this, options));
            });
        },
        shallowExtend: function (options) {
            var settings = $.extend({}, $.fn.wysihtml5.defaultOptions, options || {}, $(this).data());
            var that = this;
            return methods.bypassDefaults.apply(that, [settings]);
        },
        deepExtend: function(options) {
            var settings = $.extend(true, {}, $.fn.wysihtml5.defaultOptions, options || {});
            var that = this;
            return methods.bypassDefaults.apply(that, [settings]);
        },
        init: function(options) {
            var that = this;
            return methods.shallowExtend.apply(that, [options]);
        }
    };

    $.fn.wysihtml5 = function ( method ) {
        if ( methods[method] ) {
            return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.wysihtml5' );
        }    
    };

    $.fn.wysihtml5.Constructor = Wysihtml5;

    var defaultOptions = $.fn.wysihtml5.defaultOptions = {
        "placeholders": true,
        "font-styles": true,
        "font-sizes": false,
        "paymentlink": false,
        "orderTemplatePublicLink": false,
        "orderPrintoutTemplateLink": false,
        "color": false,
        "prefix": '',
        "emphasis": true,
        "lists": true,
        "html": false,
        "link": true,
        "mailto": true,
        "image": true,
        "orderImageLink": false,
        events: {},
        parserRules: {
            classes: {
                // (path_to_project/lib/css/wysiwyg-color.css)
                "wysiwyg-color-silver" : 1,
                "wysiwyg-color-gray" : 1,
                "wysiwyg-color-white" : 1,
                "wysiwyg-color-maroon" : 1,
                "wysiwyg-color-red" : 1,
                "wysiwyg-color-purple" : 1,
                "wysiwyg-color-fuchsia" : 1,
                "wysiwyg-color-green" : 1,
                "wysiwyg-color-lime" : 1,
                "wysiwyg-color-olive" : 1,
                "wysiwyg-color-yellow" : 1,
                "wysiwyg-color-navy" : 1,
                "wysiwyg-color-blue" : 1,
                "wysiwyg-color-teal" : 1,
                "wysiwyg-color-aqua" : 1,
                "wysiwyg-color-orange" : 1,
                // (path_to_project/lib/css/wysiwyg-font.css)
                "wysiwyg-font-size-xx-small": 1,
                "wysiwyg-font-size-x-small": 1,
                "wysiwyg-font-size-small": 1,
                "wysiwyg-font-size-medium": 1,
                "wysiwyg-font-size-large": 1,
                "wysiwyg-font-size-x-large": 1,
                "wysiwyg-font-size-xx-large": 1,
                "wysiwyg-font-size-larger": 1,
                "wysiwyg-font-size-normal": 1
            },
            tags: {
                "b":  {},
                "i":  {},
                "br": {},
                "ol": {},
                "ul": {},
                "li": {},
                "h1": {},
                "h2": {},
                "h3": {},
                "h4": {},
                "h5": {},
                "h6": {},
                "blockquote": {},
                "u": 1,
                "img": {
                    "check_attributes": {
                        "width": "numbers",
                        "alt": "alt",
                        "src": "url",
                        "height": "numbers"
                    }
                },
                "a":  {
                    check_attributes: {
                        'href': "url", // important to avoid XSS
                        'target': 'alt',
                        'rel': 'alt'
                    }
                },
                "span": 1,
                "div": 1,
                // to allow save and edit files with code tag hacks
                "code": 1,
                "pre": 1
            }
        },
        stylesheets: ["/stylesheets/wysiwyg-color.css", "/stylesheets/wysiwyg-font.css"], // (path_to_project/lib/css/wysiwyg-color.css)
        locale: "en"
    };

    if (typeof $.fn.wysihtml5.defaultOptionsCache === 'undefined') {
        $.fn.wysihtml5.defaultOptionsCache = $.extend(true, {}, $.fn.wysihtml5.defaultOptions);
    }

    var locale = $.fn.wysihtml5.locale = {
        en: {
            font_sizes: {
                normal:  "Normal",
                xxSmall: "XX-Small",
                xsmall:  "X-Small",
                small:   "Small",
                medium:  "Medium",
                large:   "Large",
                xLarge:  "X-Large",
                xxLarge: "XX-Large",
                larger:  "Larger"
            },
            font_styles: {
                normal: "Normal text",
                h1: "Heading 1",
                h2: "Heading 2",
                h3: "Heading 3",
                h4: "Heading 4",
                h5: "Heading 5",
                h6: "Heading 6"
            },
            emphasis: {
                bold: "B",
                italic: "I",
                underline: "U"
            },
            lists: {
                unordered: "Unordered list",
                ordered: "Ordered list",
                outdent: "Outdent",
                indent: "Indent"
            },
            link: {
                insert: "Insert link",
                cancel: "Cancel",
                target: "Open link in new window"
            },
            mailto: {
                insert: "Insert Email Address",
                cancel: "Cancel",
            },
            placeholder: {
                insert: "Insert Placeholder",
                cancel: "Cancel"
            },
            image: {
                insert: "Insert image",
                cancel: "Cancel"
            },
            html: {
                edit: "Edit HTML"
            },
            colours: {
                black: "Black",
                silver: "Silver",
                gray: "Grey",
                maroon: "Maroon",
                red: "Red",
                purple: "Purple",
                green: "Green",
                olive: "Olive",
                navy: "Navy",
                blue: "Blue",
                orange: "Orange"
            }
        }
    };

}(window.jQuery, window.wysihtml5);