(function ( $ ) {
    $.fn.multiStepForm = function(args) {
        if(args === null || typeof args !== 'object' || $.isArray(args))
            throw  " : Called with Invalid argument";
        var form = this;
        var tabs = form.find('.tab');
        var steps = form.find('.step');
        var formParentDiv = form.parent();

        steps.each(function(i, e){
            $(e).on('click', function(ev){
            });
        });
        form.navigateTo = function (i) {/*index*/
            /*Mark the current section with the class 'current'*/
            tabs.removeClass('current').eq(i).addClass('current');

            /*VERTICAL LINE COLOR EFFECT WHEN CLICKED ON NEXT BUTTON*/
            let parentDiv = tabs.parent().parent();
            const targetTabAttr = parentDiv.find('.current').attr('active-tab');

            if(targetTabAttr === 'general-info'){
                parentDiv.find('.general-info').addClass('proc-active');
            }
            if(targetTabAttr === 'ssc-level'){
                const profileImg = parentDiv.find('.profile-photo');
                if(!profileImg.val())
                    parentDiv.find('.error-msg').text('Please upload a profile photo!');

                parentDiv.find('.ssc-level').addClass('proc-active');
                parentDiv.find('.general-info').removeClass('proc-active').addClass('proc-completed');
            }
            if(targetTabAttr === 'hsc-level'){
                parentDiv.find('.hsc-level').addClass('proc-active');
                parentDiv.find('.ssc-level').removeClass('proc-active').addClass('proc-completed');
            }
            if(targetTabAttr === 'bachelor-degree'){
                parentDiv.find('.bachelor-degree').addClass('proc-active');
                parentDiv.find('.hsc-level').removeClass('proc-active').addClass('proc-completed');
            }
            if(targetTabAttr === 'master-degree'){
                parentDiv.find('.master-degree').addClass('proc-active');
                parentDiv.find('.bachelor-degree').removeClass('proc-active').addClass('proc-completed');
            }
            if(targetTabAttr === 'english-language'){
                parentDiv.find('.english-language').addClass('proc-active');
                parentDiv.find('.master-degree').removeClass('proc-active').addClass('proc-completed');
            }
            if(targetTabAttr === 'testimonial'){
                parentDiv.find('.testimonial').addClass('proc-active');
                parentDiv.find('.english-language').removeClass('proc-active').addClass('proc-completed');
            }
            if(targetTabAttr === 'interested-country'){
                parentDiv.find('.interested-country').addClass('proc-active');
                parentDiv.find('.testimonial').removeClass('proc-active').addClass('proc-completed');
            }
            if(targetTabAttr === 'preview-tab'){
                $('.infoDiv').hide();
                $('.previewDiv').show();
            }

            // Show only the navigation buttons that make sense for the current section:
            form.find('.previous').toggle(i > 0);
            atTheEnd = i >= tabs.length - 1;
            form.find('.next').toggle(!atTheEnd);
            // console.log('atTheEnd='+atTheEnd);
            form.find('.submit').toggle(atTheEnd);
            fixStepIndicator(curIndex());
            return form;
        }
        function curIndex() {
            /*Return the current index by looking at which section has the class 'current'*/
            return tabs.index(tabs.filter('.current'));
        }
        function fixStepIndicator(n) {
            steps.each(function(i, e){
                i == n ? $(e).addClass('active') : $(e).removeClass('active');
            });
        }
        /* Previous button is easy, just go back */
        form.find('.previous').click(function() {

            /* VERTICAL LINE COLOR EFFECT WHEN CLICKED ON PREVIOUS BUTTON*/
            let parentDiv = tabs.parent().parent();
            const targetTabAttr = parentDiv.find('.current').attr('active-tab');

            if(targetTabAttr === 'preview-tab'){
                $('.infoDiv').show();
                $('.previewDiv').hide();
            }
            if(targetTabAttr === 'interested-country'){
                parentDiv.find('.info-div').show();
                parentDiv.find('.parent-container').removeClass('col-md-12').addClass('col-md-8');

                parentDiv.find('.interested-country').removeClass('proc-active proc-completed');
                parentDiv.find('.testimonial').removeClass('proc-completed').addClass('proc-active');
            }
            if(targetTabAttr === 'testimonial'){
                parentDiv.find('.testimonial').removeClass('proc-active proc-completed');
                parentDiv.find('.english-language').removeClass('proc-completed').addClass('proc-active');
            }
            if(targetTabAttr === 'english-language'){
                parentDiv.find('.english-language').removeClass('proc-active proc-completed');
                parentDiv.find('.master').removeClass('proc-completed').addClass('proc-active');
            }
            if(targetTabAttr === 'english-language'){
                parentDiv.find('.english-language').removeClass('proc-active proc-completed');
                parentDiv.find('.master-degree').removeClass('proc-completed').addClass('proc-active');
            }
            if(targetTabAttr === 'master-degree'){
                parentDiv.find('.master-degree').removeClass('proc-active proc-completed');
                parentDiv.find('.bachelor-degree').removeClass('proc-completed').addClass('proc-active');
            }
            if(targetTabAttr === 'bachelor-degree'){
                parentDiv.find('.bachelor-degree').removeClass('proc-active proc-completed');
                parentDiv.find('.hsc-level').removeClass('proc-completed').addClass('proc-active');
            }
            if(targetTabAttr === 'hsc-level'){
                parentDiv.find('.hsc-level').removeClass('proc-active proc-completed');
                parentDiv.find('.ssc-level').removeClass('proc-completed').addClass('proc-active');
            }
            if(targetTabAttr === 'ssc-level'){
                parentDiv.find('.ssc-level').removeClass('proc-active proc-completed');
                parentDiv.find('.general-info').removeClass('proc-completed').addClass('proc-active');

            }
            form.navigateTo(curIndex() - 1);
        });

        /* Next button goes forward iff current block validates */
        form.find('.next').click(function() {

            const profilePhoto =  $(formParentDiv).find('.profile-photo').val();
            if(!profilePhoto){
                formParentDiv.find('.profile').css({"border" : "3px solid red", "border-radius": "50%"});
                return false;
            }

            if('validations' in args && typeof args.validations === 'object' && !$.isArray(args.validations)){
                if(!('noValidate' in args) || (typeof args.noValidate === 'boolean' && !args.noValidate)){
                    form.validate({
                        errorPlacement:function (){
                            return false;
                        }});
                    if(form.valid() == true){
                        form.navigateTo(curIndex() + 1);
                        return true;
                    }
                    return false;
                }
            }
            form.navigateTo(curIndex() + 1);
        });
        form.find('.submit').on('click', function(e){
            if(typeof args.beforeSubmit !== 'undefined' && typeof args.beforeSubmit !== 'function')
                args.beforeSubmit(form, this);
            /*check if args.submit is set false if not then form.submit is not gonna run, if not set then will run by default*/
            if(typeof args.submit === 'undefined' || (typeof args.submit === 'boolean' && args.submit)){
                form.submit();
            }
            return form;
        });
        /*By default navigate to the tab 0, if it is being set using defaultStep property*/
        typeof args.defaultStep === 'number' ? form.navigateTo(args.defaultStep) : null;

        form.noValidate = function() {

        }
        return form;
    };
}( jQuery ));
