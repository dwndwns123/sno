var ftt = {
  spinOpts: {
    lines: 13, // The number of lines to draw
    length: 20, // The length of each line
    width: 10, // The line thickness
    radius: 30, // The radius of the inner circle
    corners: 1, // Corner roundness (0..1)
    rotate: 0, // The rotation offset
    direction: 1, // 1: clockwise, -1: counterclockwise
    color: '#3FABE9', // #rgb or #rrggbb
    speed: 1, // Rounds per second
    trail: 60, // Afterglow percentage
    shadow: false, // Whether to render a shadow
    hwaccel: false, // Whether to use hardware acceleration
    className: 'spinner', // The CSS class to assign to the spinner
    zIndex: 2e9, // The z-index (defaults to 2000000000)
    top: 'auto', // Top position relative to parent in px
    left: 'auto' // Left position relative to parent in px
  },
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

    if($('#conceptsDropdown').val() !== ''){
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
      var $this = $(e.target);
      var wId = $this.attr('id').split('-')[1];
      var numThis = $this.closest('form').find('#numThis').val();
      var thisType = ($this.closest('form').find('#itemType').val().toString() === "0" ? "RFE" : "Health Issue");
      if(numThis < 2){
        bootbox.alert('Each encounter must have at least one RFE and at least one Health Issue.');
      } else {
        bootbox.confirm("Delete "+thisType+" #"+wId+" - Are you sure?", function(result){
          if(result){
            // TODO: show some kind of spinner (spin.js) while this call is made
            $.ajax({
              url:      'deleteItem.php',
              type:     'POST',
              data:     'id='+wId,
              success:  function(response, textStatus, jqXHR){
                bootbox.alert(thisType+" #"+wId+" successfully deleted.", function(){
                  window.location.href = "review-encounter.php";
                })
              },
              error:    function(jqXHR, textStatus, errorThrown){
                alert('error: '+errorThrown);
              }
            });
          }
        });
      }
    });

    $('.deleteEncounterBtn').on('click', function(e){
      e.preventDefault();
      var $this = $(e.target);
      var wId = $this.attr('id').split('-')[1];
      bootbox.confirm("Delete Encounter #"+wId+" - Are you sure?", function(result){
        if(result){
          // TODO: show some kind of spinner (spin.js) while this call is made
          $.ajax({
            url:      'deleteEncounter.php',
            type:     'POST',
            data:     'id='+wId,
            success:  function(response, textStatus, jqXHR){
              bootbox.alert("Encounter #"+wId+" successfully deleted.", function(){
                window.location.href = "index.php";
              });
            },
            error:    function(jqXHR, textStatus, errorThrown){
              alert('error: '+errorThrown);
            }
          });
        }
      });
    });

    $('.itemsHolder .spin').each(function(){
      var $this = $(this);
      var spinner = new Spinner(ftt.spinOpts).spin($this[0]);
    });

    $('.encounters-list .collapse').not('fetched').on('shown', function(){
      var $this = $(this),
        $container = $this.find('.itemsHolder'),
        wId = $container.attr('id').split('-')[1];

      $.ajax({
        url:        'getItems.php',
        type:       'POST',
        data:       'enc='+wId,
        dataType:   'json',
        success:    function(response, textStatus, jqXHR){
          $this.addClass('fetched');
          var insertHtml = ftt.items.write(response);
          $container.empty().append(insertHtml);
        },
        error:      function(jqXHR, textStatus, errorThrown){
          alert('error: '+errorThrown);
        }
      });
    });

    $('.editlabelBtn').on('click', function(e){
      e.preventDefault();
      var $this = $(this);
      bootbox.prompt("Enter new label for this encounter:", function(result){
        if(result){
          $.ajax({
            url:      'newLabel.php',
            type:     'POST',
            data:     'txt='+result+'&enc='+$this.data('encounterid').toString(),
            success:  function(response, textStatus, jqXHR){
              window.location.href="encounters.php?scrollTo="+$this.data('encounterid');
            },
            error:    function(jqXHR, textStatus, errorThrown){
              alert('error: '+errorThrown);
            }
          });
        }
      });
    });

    if(($('.encounters-list').length > 0) && (window.location.search.indexOf('scrollTo') !== -1)){
      var wId = window.location.search.split('scrollTo=')[1];
      var wX = $('#collapse'+wId).closest('.accordion-group').offset().top;
      window.scrollTo(0, wX);
      $('#collapse'+wId).parent().find('.accordion-toggle').trigger('click');
    }
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
  },
  items: {
    write: function(data){
      tools.dir(data);
      var str = '<dl class="dl-horizontal"><dt>RFEs</dt><dd><ul>';
      for(var x=0; x<data.length; x++){// RFEs only
        if(data[x].type === "0"){
          str += '<li>'+data[x].term+'</li>';
        }
      }
      str += '</ul></dd><dt>Health Issues</dt><dd><ul>';
      for(var y=0; y<data.length; y++){// HIs only
        if(data[y].type === "1"){
          str += '<li>'+data[y].term+'</li>';
        }
      }
      str += '</ul></dd></dl>';

      return str;
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