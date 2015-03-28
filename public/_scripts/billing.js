/**
 * Created by Sean on 3/17/2015.
 */
(function () {

    var StripeBilling = {

        init: function() {

            this.form = $("#billing_form");
            this.submitBtn = this.form.find('input[type=submit]');
            this.submitBtnValue = this.form.find('input[type=submit]').val();
            var stripeKey = $('meta[name="publishable-key"]').attr('content');

            Stripe.setPublishableKey(stripeKey);

            this.bindEvents();

        },

        bindEvents: function() {

            this.form.on('submit', $.proxy(this.sendToken, this));

        },

        sendToken: function(event) {

            event.preventDefault();
            this.submitBtn.val('Please Wait').prop('disabled',true);;

            Stripe.createToken({

                number: $('#credit_card').val(),
                cvc: $('#cvc').val(),
                exp_month: $('#exp_month').val(),
                exp_year: $('#exp_year').val()
            }, $.proxy(this.stripeResponseHandler, this));



        },

        stripeResponseHandler: function(status, response) {

            if (response.error) {

                this.submitBtn.prop('disabled',false);
                this.submitBtn.val(this.submitBtnValue);
                return $('.payment-errors').css({'display' : 'block'}).find('span').html(response.error.message);

            }

            this.submitBtn.prop('disabled',false);
            this.submitBtn.val(this.submitBtnValue);

            $('<input>', {

                type: 'hidden',
                name: 'stripeToken',
                value: response.id

            }).appendTo(this.form);

            //this.form[0].submit();


        }

    };

    StripeBilling.init();

})();