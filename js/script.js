var ftt = {
  init: function(){
    $('input[maxlength]').maxlength();

    $('#rfeSearchBtn').click(function(){
      ftt.concepts.narrow();
    });
  },
  concepts: {
    narrow: function(){
      var searchText = $('#rfeSearch').val();

      $.ajax({
        url:      'searchConcepts.php',
        type:     'POST',
        data:     'searchText='+searchText,
        dataType: 'json',
        success:  function(response, textStatus, jqXHR){
          tools.rewriteDropdown($('#rfeConcepts'), response);
        },
        error:    function(jqXHR, textStatus, errorThrown){
          alert('error: '+errorThrown);
        }
      });
    }
  }
};


var tools = {
  log: function(msg){
    if(window && window.console){
      console.log(msg);
    }
  },
  dir: function(obj){
    if(window && window.console){
      console.dir(obj);
    }
  },
  rewriteDropdown: function($obj, data){
    var $tmp = $obj.find('option')[0];
    $obj.empty().append($tmp);
    for(var x=0; x<data.length; x++){
      $obj.append('<option value="'+data[x].conceptId+'">'+data[x].term+'</option>');
    }
  }
};

$(function(){
  ftt.init();
});