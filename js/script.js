var ftt = {
  init: function(){
    $('input[maxlength]').maxlength();

    $('#searchBtn').on('click', function(){
      ftt.concepts.narrow();
    });
    $('#clearBtn').on('click', function(){
      ftt.concepts.reset();
    });

    $('#conceptsDropdown').on('change', function(){
      ftt.concepts.getSynonyms();
    });
  },
  concepts: {
    narrow: function(){
      var searchText = $('#searchBox').val();

      $.ajax({
        url:      'searchConcepts.php',
        type:     'POST',
        data:     'searchText='+searchText,
        dataType: 'json',
        success:  function(response, textStatus, jqXHR){
          $('#conceptsDropdown').prop('size', 5);
          tools.rewriteDropdown($('#conceptsDropdown'), response);
          $('dl.synonyms').hide();
          
          if(searchText === ''){
            $('#conceptsDropdown').prop('size', 1);
            $('#conceptsDropdown')[0].selectedIndex = 0;
          }
        },
        error:    function(jqXHR, textStatus, errorThrown){
          alert('error: '+errorThrown);
        }
      });
    },
    reset: function(){
      $('#searchBox').val('');
      ftt.concepts.narrow();
    },
    getSynonyms: function(){
      var cid = $('#conceptsDropdown').val();
      
      $.ajax({
        url:      'getSynonyms.php',
        type:     'POST',
        data:     'syn='+cid,
        dataType: 'json',
        success:  function(response, textStatus, jqXHR){
          ftt.concepts.showSynonyms(response);
        },
        error:    function(jqXHR, textStatus, errorThrown){
          alert('error: '+errorThrown);
        }
      });
    },
    showSynonyms: function(data){
      var str = '<ul>';
      for(var x=0; x<data.length; x++){
        str += '<li>'+data[x].synonym+'</li>';
      }
      str += '</ul>';
      $('dl.synonyms dd').empty().append(str);
      $('dl.synonyms').show();
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