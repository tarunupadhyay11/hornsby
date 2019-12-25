let userEditUrl = $('input#useredit').val();
let csrfToken = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function () {
    $('#userdatatable').DataTable({
    "ajax": {
      "url": '/get-all-users',
      "type": "POST",
      "data": function data(_data) {
        _data._token = csrfToken;
      }
    },
    "dom": '<"pull-left"f><"pull-right"l>tip',
    "lengthChange": false,
    "info": false,
    "columns": [
	{"data": "username"}, 
	{"data": "firstname"},
	{"data": "lastname"},
	{"data": "displayname"}, 
	{"data": "email"},
	{"data": "role.name"},
	{"data": "id"},
	{"data": "id"}
	],
    "columnDefs": [{
      "render": function render(data, type, row) {
        if (row.default_transcriber != undefined || row.default_transcriber != null) {
          var dn = row.default_transcriber.displayname;
          return dn;
        } else {
          return '';
        }
      },
      "targets": 6
    }, {
      "render": function render(data, type, row) {
        var uname = row.id + "," + "\'" + row.displayname + "\'";
        var url = userEditUrl.replace(':id', row.id);
        var actionv = '<a style="padding:5px;color:#fff" href="javascript:void(0);" onclick="return window.getspassword(' + row.id + ')">Show Password</a>';
        actionv += "<a href='" + url + "' style='padding:5px;color:#fff'>Edit</a>";
        actionv += '<a style="padding:5px;color:#fff" href="javascript:void(0);" onclick="return window.resetpass(' + uname + ')">Reset Password</a><br/>';
		if(row.block==1){
			actionv += '<a style="padding:5px;color:#fff" href="javascript:void(0);" onclick="return window.activeDeactiveUser(' + row.id + ',0)">Activate User</a>';
		}
		else{
			actionv += '<a style="padding:5px;color:#fff" href="javascript:void(0);" onclick="return window.activeDeactiveUser(' + row.id + ',1)">Disable User</a>';
		}
		 
        return actionv;
      },
      "width": "25%",
      "targets": 7
    }],
    "createdRow": function createdRow(row, data, dataIndex) {
      if (data.block == 0) {
        $(row).addClass("activeclass");
		$(row).prop("title",'Active');
      } else {
        $(row).addClass("deactiveclass");
		$(row).prop("title",'Deactive');
      }
    }
  });

  var engineUserType = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: '/get-usertypes?q=%QUERY%',
      wildcard: '%QUERY',
      transport: function transport(opts, onSuccess, onError) {
        var url = opts.url.split("#")[0];
        var query = opts.url.split("#")[1];
        $.ajax({
          url: url,
          data: {
            q: query,
            _token: csrfToken
          },
          type: "POST",
          success: onSuccess,
          error: onError
        });
      }
    }
  });
  $("#usertypes").typeahead({
    hint: true,
    highlight: true,
    minLength: 1
  }, {
    name: 'usertypes',
    displayKey: 'name',
    source: engineUserType.ttAdapter(),
    templates: {
      empty: ['<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'],
      header: ['<div class="list-group search-results-dropdown">'],
      suggestion: function suggestion(data) {
        return '<a  class="list-group-item">' + data.name + '</a>';
      }
    }
  }).on('typeahead:selected', function (e, datanum) {
    $('#usertypesval').val(datanum.id); // save selected id to input
	$('#usertypes').typeahead('val', window._.upperFirst(datanum.name));
  });
  var engineUserCountry = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: '/get-countries?q=%QUERY%',
      wildcard: '%QUERY',
      transport: function transport(opts, onSuccess, onError) {
        var url = opts.url.split("#")[0];
        var query = opts.url.split("#")[1];
        $.ajax({
          url: url,
          data: {
            q: query,
            _token: csrfToken
          },
          type: "POST",
          success: onSuccess,
          error: onError
        });
      }
    }
  });
  $("#country").typeahead({
    hint: true,
    highlight: true,
    minLength: 1
  }, {
    name: 'usercountries',
    displayKey: 'name',
    source: engineUserCountry.ttAdapter(),
    templates: {
      empty: ['<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'],
      header: ['<div class="list-group search-results-dropdown">'],
      suggestion: function suggestion(data) {
        return '<a  class="list-group-item">' + data.name + '</a>';
      }
    }
  }).on('typeahead:selected', function (e, datanum) {
    $('#countryval').val(datanum.id); // save selected id to input	
    $('#usercountryval').val(datanum.id);
	$('#country').typeahead('val', window._.upperFirst(datanum.name));
  });
  var engineState = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: '/get-states?q=%QUERY%',
      wildcard: '%QUERY',
      transport: function transport(opts, onSuccess, onError) {
        var url = opts.url.split("#")[0];
        var query = opts.url.split("#")[1];
        $.ajax({
          url: url,
          data: {
            q: query,
            cid: $('#usercountryval').val(),
            _token: csrfToken
          },
          type: "POST",
          success: onSuccess,
          error: onError
        });
      }
    }
  });
  $("#state").typeahead({
    hint: true,
    highlight: true,
    minLength: 1
  }, {
    name: 'userstates',
    displayKey: 'name',
    source: engineState.ttAdapter(),
    templates: {
      empty: ['<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'],
      header: ['<div class="list-group search-results-dropdown">'],
      suggestion: function suggestion(data) {
        return '<a  class="list-group-item">' + data.name + '</a>';
      }
    }
  }).on('typeahead:selected', function (e, datanum) {
    $('#stateval').val(datanum.id); // save selected id to input
    $('#userstateval').val(datanum.id);
	$('#state').typeahead('val', window._.upperFirst(datanum.name));
  });
  var engineCity = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: '/get-cities?q=%QUERY%',
      wildcard: '%QUERY',
      transport: function transport(opts, onSuccess, onError) {
        var url = opts.url.split("#")[0];
        var query = opts.url.split("#")[1];
        $.ajax({
          url: url,
          data: {
            q: query,
            sid: $('#userstateval').val(),
            _token: csrfToken
          },
          type: "POST",
          success: onSuccess,
          error: onError
        });
      }
    }
  });
  $("#city").typeahead({
    hint: true,
    highlight: true,
    minLength: 1
  }, {
    name: 'usercities',
    displayKey: 'name',
    source: engineCity.ttAdapter(),
    templates: {
      empty: ['<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'],
      header: ['<div class="list-group search-results-dropdown">'],
      suggestion: function suggestion(data) {
        return '<a  class="list-group-item">' + data.name + '</a>';
      }
    }
  }).on('typeahead:selected', function (e, datanum) {
    $('#cityval').val(datanum.id); // save selected id to input
    $('#usercityval').val(datanum.id);
	$('#city').typeahead('val', window._.upperFirst(datanum.name));
  });
  var engineTrascriber = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: '/get-transcriber?q=%QUERY%',
      wildcard: '%QUERY',
      transport: function transport(opts, onSuccess, onError) {
        var url = opts.url.split("#")[0];
        var query = opts.url.split("#")[1];
        $.ajax({
          url: url,
          data: {
            q: query,
            _token: csrfToken
          },
          type: "POST",
          success: onSuccess,
          error: onError
        });
      }
    }
  });
  $("#trascriber").typeahead({
    hint: true,
    highlight: true,
    minLength: 1
  }, {
    name: 'usertrascriber',
    displayKey: 'name',
    source: engineTrascriber.ttAdapter(),
    templates: {
      empty: ['<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'],
      header: ['<div class="list-group search-results-dropdown">'],
      suggestion: function suggestion(data) {
        return '<a  class="list-group-item">' + data.name + '</a>';
      }
    }
  }).on('typeahead:selected', function (e, datanum) {
    $('#trascriberval').val(datanum.id); // save selected id to input	 
	$('#trascriber').typeahead('val', window._.upperFirst(datanum.name));
  });
  
  
$('input[name="chk_dictation"]').click(function() { 
    if($(this).is(':checked'))
       $(this).val(1)
    else
       $(this).val(0)
});


 $("input[type=text]").change(function(e){  
  var changedVal = window._.upperFirst(e.target.value);
  $('input[name="'+e.target.name+'"]').val(changedVal);  
});  

$("input[type=number]").keyup(function () { 
    this.value = this.value.replace(/[^0-9\.]/g,'');
});

});

window.getspassword = function (val) {
  var str = "";
  var data = {
    "id": val,
    "_token": csrfToken
  };
  $.ajax({
    type: "POST",
    dataType: 'json',
    data: data,
    url: '/show-password',
    async: false,
    success: function success(response) {
      $('.passwordvalue').text('Your Password is: ' + response.password);
    }
  });
};

window.resetpass = function (id) {
  var data = {
    "id": id,
    "_token": csrfToken
  };
  $.ajax({
    type: "POST",
    dataType: 'json',
    data: data,
    url: '/reset-password',
    async: false,
    success: function success(response) {
      $('.passwordvalue').text('Your Password is changed,your new password is ' + response.password);
    }
  });
};

window.activeDeactiveUser = function (id,st) {
	var r = confirm("Are you sure you want to change status?!");
	if (r == true) {
	  var data = {
		"id": id,
		"status": st,
		"_token": csrfToken
	  };
	  $.ajax({
		type: "POST",
		dataType: 'json',
		data: data,
		url: '/change-user-status',
		async: false,
		success: function success(response) {
		  $('#userdatatable').DataTable().ajax.reload();
		}
	  });
	}  
};

var formArray = [];

window.addformdata = function (lbl, val) {
if(lbl!=''){
  var str = 'formd' + lbl;
  var trid = str.replace(/\s+/g, '');
  var formval = {
    tid: trid,
    tval: val,
    ttbl: lbl
  };
  var vexist = 0;

  if (typeof formArray !== 'undefined' && formArray.length > 0) {
    formArray.forEach(function (arrayItem) {
      if (arrayItem.tid == trid) {
        arrayItem.tval = val;
        vexist = 1;
      }
    });
  } else {
    vexist = 0;
  }

  if (vexist == 0) {
    formArray.push(formval);
  }

  var content = '';

  if (typeof formArray !== 'undefined' && formArray.length > 0) {
    formArray.forEach(function (arrayItem) {
      var x = arrayItem.tval;
      content += '<tr id="' + arrayItem.tid + '">';
      content += '<th scope="col">' + arrayItem.ttbl + ':</th>';
      content += '<td>' + arrayItem.tval + '</td>';
      content += '</tr>';
      $('#myformdetaildive tbody').html(content);
    });
  }
}
};
window.fixStepIndicator = function (n) {
  // This function removes the "active" class of all steps...
  var i,
      x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  } //... and adds the "active" class on the current step:
  x[n].className += " active";
};

window.editTab = function (n) {
   $('.tab').hide(); 
   $('#nextBtn').addClass('submitForm');
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block"; //
  document.getElementById("nextBtn").innerHTML = "Submit";
  $("#nextBtn").removeAttr("onclick");
  $('#nextBtn').removeAttr("type").attr("type", "submit");
};


var currentTab = 0; 
window.showTab = function (n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block"; //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
    document.getElementById("nextprediv").style.display = "block";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == x.length - 1) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  } //... and run a function that will display the correct step indicator:
  window.fixStepIndicator(n);
};

window.showTab(currentTab); 
window.nextPrev = function (n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab"); // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !window.validateForm()) return false; // Hide the current tab:
  x[currentTab].style.display = "none"; // Increase or decrease the current tab by 1:
  currentTab = currentTab + n; // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("nextprediv").style.display = "none";
    document.getElementById("regForm").submit();
    return false;
  } // Otherwise, display the correct tab:
  window.showTab(currentTab);
};

window.validateForm = function () {
  // This function deals with validation of the form fields
  var x,y,i,
      valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input"); // A loop that checks every input field in the current tab:

  for (i = 0; i < y.length; i++) {
    if (y[i].name != 'id' && y[i].name != 'chk_dictation' && y[i].name != 'cmb_user' && y[i].name != 'cmb_country' && y[i].name != 'state' && y[i].name != 'city' && y[i].name != 'cmb_trans') {
      window.addformdata(y[i].placeholder, y[i].value);
    } // If a field is empty...
	
	
	    switch (true) {
          case y[i].name == 'usertypeu' && y[i].value != '':
            y[i].className += " ";
            valid = true;
            break;
          case y[i].name == 'countryu' && y[i].value != '':
            y[i].className += " ";
            valid = true;
            break;
          case y[i].name == 'stateu' && y[i].value != '':
            y[i].className += " ";
            valid = true;
            break;
          case y[i].name == 'cityu' && y[i].value != '':
            y[i].className += " ";
            valid = true;
            break;	
          default:
		   y[i].className += " ";
           valid = true;
        }


    if (y[i].value == "") {
      // add an "invalid" class to the field:
      if (y[i].name == 'email' || y[i].name == 'txt_fax' || y[i].name == 'fax' || y[i].name == 'utrascriber' || y[i].name == 'phone' || y[i].name == 'password' || y[i].name == 'address' || y[i].name == 'id' || y[i].name == 'chk_dictation'  || y[i].name == 'notes') {
        y[i].className += " "; // and set the current valid status to false
        valid = true;
      } else {               	  
				y[i].className += " invalid";
				 $('.tt-hint').removeClass('invalid');
				 $('#trascriberval').removeClass('invalid');
				 if(y[i].name == 'cmb_trans'){
					 valid = true;
				 }
				 else{				 
                  valid = false;   
                 }				 
      }
    } else {
      if (y[i].name == 'email') {
        if (!window.validateEmail(y[i].value)) {
          y[i].className += " invalid";
          valid = false;
        } else {
          y[i].className += " ";
          valid = true;
        }
      }
    }
  } // If the valid status is true, mark the step as finished and valid:


  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }

  return valid; // return the valid status
};

window.formatphone = function (inp, nam) {
  var name = nam;
  var s = inp;
  s = s.replace(/[^ 0-9]+/g, '');
  if(s!=''){
  s = '(' + s; //num = s.substr(0,0) + "(" + s.substr(1,3) + ")" + s.substr(4,3) + "-" + s.substr(5,4)

  num = s.substr(0, 4) + ")" + s.substr(4, 3) + "-" + s.substr(7, 4);
  document.frm[nam].value = num;
  }
  else{
	  document.frm[nam].value = '';
  }
};

window.validateEmail = function ($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test($email);
};