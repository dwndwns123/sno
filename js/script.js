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

    if($('#conceptsDropdown option:selected').length > 0){
      ftt.concepts.getSynonyms();
    }

    $('#nextBtn').on('click', function(e){
      e.preventDefault();
      $('#addAnother').val("false");
      $(this).closest('form').submit();
    });

    $('#finishedBtn').on('click', function(e){
      e.preventDefault();
      $(this).closest('form').attr('action', 'review-encounter.php').submit();
    });

    $('.deleteItemBtn').on('click', function(e){
      e.preventDefault();

    });

    $('.deleteEncounterBtn').on('click', function(e){
      e.preventDefault();
      bootbox.confirm("Are you sure?", function(result){
        var wId = $(e.target).attr('id').split('-')[1];
        if(result){
          // TODO: show some kind of spinner (spin.js) while this call is made
          $.ajax({
            url:      'deleteEncounter.php',
            type:     'POST',
            data:     'id='+wId,
            success:  function(response, textStatus, jqXHR){
              bootbox.alert("Encounter "+wId+" successfully deleted.", function(){
                window.location.href = "index.php";
              })
            },
            error:    function(jqXHR, textStatus, errorThrown){
              alert('error: '+errorThrown);
            }
          });
        }
      });
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