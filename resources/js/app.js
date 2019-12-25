/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./sb-admin.min.js');
require( 'datatables.net' );
require( 'datatables.net-dt' );

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

require('typeahead.js/dist/typeahead.jquery.js');
Bloodhound = require("typeahead.js/dist/bloodhound.min.js")
