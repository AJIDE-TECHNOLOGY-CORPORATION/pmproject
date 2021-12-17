$(document).ready(function () {
    'use strict';
    /* master company form validation */
    $("#MyCompanyForm").validate({
        errorClass: 'text-danger',
        rules: {
            'company_email': {
                required: true,
                email: true,
            },
            'company_name': {
                required: true,
            },
            'company_state': {
                required: true,
            },
            'company_country': {
                required: true,
            },
            'company_zip': {
                required: true,
            },
        },
        messages: {
            'company_email': {
                required: " email required.",
                email: true,
            },
            'company_name': {
                required: "company name required.",
            },
            'company_state': {
                required: "state required",
            },
            'company_country': {
                required: "country required.",
            },
            'company_zip': {
                required: "zip code required.",
            },
        },
    });
    /* Master preference form validation */
    $("#MyPreferenceForm").validate({
        errorClass: 'text-danger',
        rules: {
            'default_timezone': {
                required: true,
            },
            'default_currency': {
                required: true,
            },
            'default_dateformat': {
                required: true,
            },
            'default_financialyear': {
                required: true,
            },
        },
        messages: {
            'default_timezone': {
                required: "timezone required.",
            },
            'default_currency': {
                required: "currency_required.",
            },
            'default_dateformat': {
                required: "dateformat required.",
            },
            'default_financialyear': {
                required: "financial year required.",
            },
        }
    });
    /* Master Account form validation */
    $("#MyAccountForm").validate({
        errorClass: 'text-danger',
        rules: {
            'email': {
                required: true,
                email: true,
            },
            'phone': {
                required: true,
            },
            'name': {
                required: true,
            },
        },
        messages: {
            'email': {
                required: "email required.",
            },
            'phone': {
                required: "phone number required.",
            },
            'name': {
                required: "Name required.",
            },
        }
    });
    /* customer form validation */
    $("#MyCustomerForm").validate({
        errorClass: 'text-danger',
        rules: {
            'display_name': {
                required: true,
            },
            'email': {
                required: true,
                email: true,
            },
            'password' : {
                minlength:6,
            },
            'phone': {
                required: true,
            },
            'billing_address1': {
                required: true,
            },
            'billing_address_name': {
                required: true,
            },
            'billing_address_city': {
                required: true,
            },
            'billing_address_state': {
                required: true,
            },
            'billing_address_phone': {
                required: true,
            },
            'billing_address_country': {
                required: true,
            },
            'billing_address_zip': {
                required: true,
            },
            'shipping_address1': {
                required: true,
            },
            'shipping_address_name': {
                required: true,
            },
            'shipping_address_city': {
                required: true,
            },
            'shipping_address_state': {
                required: true,
            },
            'shipping_address_phone': {
                required: true,
            },
            'shipping_address_country': {
                required: true,
            },
            'shipping_address_zip': {
                required: true,
            },
        },
        messages: {
            'display name': {
                required: "display name required.",
            },
            'email': {
                required: 'email field required',
            },
            'phone': {
                required: "phone number required.",
            },
            'billing_address1': {
                required: "shipping address required.",
            },
            'billing_address_name': {
                required: "billing address name required.",
            },
            'billing_address_city': {
                required: "billing address city required.",
            },
            'billing_address_state': {
                required: "billing address state required.",
            },
            'billing_address_country': {
                required: "billing address country required.",
            },
            'billing_address_phone': {
                required: "billing address phone required.",
            },
            'billing_address_zip': {
                required: "billing address zip required.",
            },
            'shipping_address1': {
                required: "shipping address required.",
            },
            'shipping_address_name': {
                required: "shipping address name required.",
            },
            'shipping_address_city': {
                required: "shipping address city required.",
            },
            'shipping_address_state': {
                required: "shipping address state required.",
            },
            'shipping_address_country': {
                required: "shipping address country required.",
            },
            'shipping_address_phone': {
                required: "shipping address phone required.",
            },
            'shipping_address_zip': {
                required: "shipping address zip required.",
            },
        }
    });
    /* Payment form validation */
    $("#MyPaymentForm").validate({
        errorClass: 'text-danger',
        rules: {
            'paid_amount': {
                required: true,
                number: true,
            },
            'invoice_number': {
                required: true,
            },
            'paid_date': {
                required: true,
            },
            'payment_mode': {
                required: true,
            },
        },
        messages: {
            'paid_amount': {
                required: "paid amount required.",
            },
            'invoice_number': {
                required: "invoice number required.",
            },
            'paid_date': {
                required: "paid_date required.",
            },
            'payment_mode': {
                required: "payment mode required.",
            },
        }
    });
    /* Expense form validation */
    $("#MyExpenseForm").validate({
        errorClass: 'text-danger',
        rules: {
            'amount': {
                required: true,
                number: true,
            },
            'customer_id': {
                required: true,
            },
            'expense_category_id': {
                required: true,
            },
            'date': {
                required: true,
            },
        },
        messages: {
            'amount': {
                required: "amount required.",
            },
            'expense_category_id': {
                required: "please choose expense category.",
            },
            'customer_id': {
                required: "please choose customer.",
            },
            'date': {
                required: "date field required.",
            },
        }
    });

    $("#MyNotesForm").validate({
        errorClass: 'text-danger',
        rules: {
            'title': {
                required: true,
            },
            'subject': {
                required: true,
            },
        },
        messages: {
            'title': {
                required: "title required.",

            },
            'subject': {
                required: "subject required.",
            },
        }
    });

    $("#MyAccountsForm").validate({
        errorClass: 'text-danger',
        rules: {
            'name': {
                required: true,
            },
            'bank_name': {
                required: true,
            },
            'account_number': {
                required: true,
                number: true,
            },
            'balance': {
                required: true,
                number: true,
            },
        },
        messages: {
            'name': {
                required: "Name required.",

            },
            'bank_name': {
                required: "Bank Name required.",
            },
            'account_number': {
                required: "Account Number required.",
            },
            'balance': {
                required: "Opening Balance required.",
            },
        }
    });

/* transfer form validation */
    $("#MyTransferForm").validate({
        errorClass: 'text-danger',
        rules: {
            'from_id': {
                required: true,
            },
            'to_id': {
                required: true,
            },
            'amount': {
                required: true,
                number: true,
            },
            'date': {
                required: true,

            },
        },
        messages: {
            'from_id': {
                required: "From Name required.",

            },
            'to_id': {
                required: "TO Name required.",
            },
            'amount': {
                required: "Amount required.",
            },
            'date': {
                required: "Date required.",
            },
        }
    });



/* todo form validation */
$("#MyTodoForm").validate({
    errorClass: 'text-danger',
    rules: {
        'title': {
            required: true,
        },
        'due_date': {
            required: true,
        },

    },
    messages: {
        'title': {
            required: "Title required.",

        },
        'due_date': {
            required: "Due date required.",
        },
    }
});

/* stripe key validation */
$("#MyPaymentMaster").validate({
    errorClass: 'text-danger',
    rules: {
        'stripe_key': {
            required: function() {
                return ($('#stripe_status').is(':checked'));
            }
        },
        'stripe_secret': {
            required: function() {
                return ($('#stripe_status').is(':checked'));
            }
        },
        'paypal_client_id': {
            required: function() {
                return ($('#paypal_status').is(':checked'));
            }
        },
        'paypal_secret': {
            required: function() {
                return ($('#paypal_status').is(':checked'));
            }
        },
        'paypal_mode': {
            required: function() {
                return ($('#paypal_status').is(':checked'));
            }
        },
        'razorpay_key': {
            required: function() {
                return ($('#razorpay_status').is(':checked'));
            }
        },
        'razorpay_secret': {
            required: function() {
                return ($('#razorpay_status').is(':checked'));
            }
        },
    },
    messages: {
        'stripe_key': {
            required: "Stripe key required.",
        },
        'stripe_secret': {
            required: "Stripe secret key required.",
        },
        'paypal_client_id': {
            required: "Paypal Client Id key required.",
        },
        'paypal_secret': {
            required: "Paypal secret key required.",
        },
        'paypal_mode': {
            required: "Paypal mode required.",
        },
        'razorpay_key': {
            required: "Razorpay key required.",
        },
        'razorpay_secret': {
            required: "Razorpay secret key required.",
        },
    }
});

/* email form validation */
$("#MyEmailMaster").validate({
    errorClass:"text-danger",
    rules: {
        'mail_from_address':{
            required: true,
           },
        'mail_from_name':{
            required: true,
        },
        'mail_encryption':{
            required: true,
        },
        'mail_user_name':{
            required: true,
        },
        'mail_driver':{
            required: true,
        },
        'mail_host':{
            required: true,
        },
        'mail_port':{
            required: true,
        },
    }     ,
    messages: {
        'mail_from_address':{
            required: " Mail from address required.",
           },
        'mail_from_name':{
            required: "Mail from name required.",
        },
        'mail_encryption':{
            required: "Mail encryption required.",
        },
        'mail_user_name':{
            required: "Mail user name required.",
        },
        'mail_driver':{
            required: "Mail driver required.",
        },
        'mail_host':{
            required: "Mail host required.",
        },
        'mail_port':{
            required: "Mail port required.",
        },
    }
});


  /* customer form validation */
  $("#MyCustomerEditProfileForm").validate({
    errorClass: 'text-danger',
    rules: {
        'display_name': {
            required: true,
        },
        'email': {
            required: true,
            email: true,
        },
        'password' : {
            minlength:6,
        },
        'phone': {
            required: true,
        },
        'billing_address1': {
            required: true,
        },
        'billing_address_name': {
            required: true,
        },
        'billing_address_city': {
            required: true,
        },
        'billing_address_state': {
            required: true,
        },
        'billing_address_phone': {
            required: true,
        },
        'billing_address_country': {
            required: true,
        },
        'billing_address_zip': {
            required: true,
        },
        'shipping_address1': {
            required: true,
        },
        'shipping_address_name': {
            required: true,
        },
        'shipping_address_city': {
            required: true,
        },
        'shipping_address_state': {
            required: true,
        },
        'shipping_address_phone': {
            required: true,
        },
        'shipping_address_country': {
            required: true,
        },
        'shipping_address_zip': {
            required: true,
        },
    },
    messages: {
        'display name': {
            required: "display name required.",
        },
        'email': {
            required: 'email field required',
        },
        'phone': {
            required: "phone number required.",
        },
        'billing_address1': {
            required: "shipping address required.",
        },
        'billing_address_name': {
            required: "billing address name required.",
        },
        'billing_address_city': {
            required: "billing address city required.",
        },
        'billing_address_state': {
            required: "billing address state required.",
        },
        'billing_address_country': {
            required: "billing address country required.",
        },
        'billing_address_phone': {
            required: "billing address phone required.",
        },
        'billing_address_zip': {
            required: "billing address zip required.",
        },
        'shipping_address1': {
            required: "shipping address required.",
        },
        'shipping_address_name': {
            required: "shipping address name required.",
        },
        'shipping_address_city': {
            required: "shipping address city required.",
        },
        'shipping_address_state': {
            required: "shipping address state required.",
        },
        'shipping_address_country': {
            required: "shipping address country required.",
        },
        'shipping_address_phone': {
            required: "shipping address phone required.",
        },
        'shipping_address_zip': {
            required: "shipping address zip required.",
        },
    }
});

    /* project form validation */
    $("#MyProjectForm").validate({
        errorClass: 'text-danger',
        rules: {

            'title': {
                required: true,
            },
            'start_date': {
                required: true,
            },
            'customer_id': {
                required: true,
            },
            'end_date': {
                required: true,
            },
            'description': {
                required: true,
            }

        },
        messages: {
            'title': {
                required: "Title required.",
            },
            'start_date': {
                required: "Start date required.",
            },
            'end_date': {
                required: "End date required.",
            },
            'customer_id' : {
                required: "Customer field required."
            },
            'description': {
                required: "Description field required.",
            }
        }
    });


    /* Task form validation */
    $("#MyTaskForm").validate({
        errorClass: 'text-danger',
        rules: {

            'title': {
                required: true,
            },
            'start_date': {
                required: true,
            },

            'deadline_date': {
                required: true,
            },
            'description': {
                required: true,
            }

        },
        messages: {
            'title': {
                required: "Title required.",
            },
            'start_date': {
                required: "Start date required.",
            },
            'deadline_date': {
                required: "End date required.",
            },
            'description': {
                required: "Description field required.",
            }
        }
    });

});
