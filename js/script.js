var ftt = {
	spinOpts : {
		lines : 13, // The number of lines to draw
		length : 20, // The length of each line
		width : 10, // The line thickness
		radius : 30, // The radius of the inner circle
		corners : 1, // Corner roundness (0..1)
		rotate : 0, // The rotation offset
		direction : 1, // 1: clockwise, -1: counterclockwise
		color : '#3FABE9', // #rgb or #rrggbb
		speed : 1, // Rounds per second
		trail : 60, // Afterglow percentage
		shadow : false, // Whether to render a shadow
		hwaccel : false, // Whether to use hardware acceleration
		className : 'spinner', // The CSS class to assign to the spinner
		zIndex : 2e9, // The z-index (defaults to 2000000000)
		top : 'auto', // Top position relative to parent in px
		left : 'auto' // Left position relative to parent in px
	},

	init : function() {
		// implement nice maxlength plugin
		$('input[maxlength]').maxlength();

		// SCT First button actions
		$('#searchBtn').on('click', function() {
			ftt.concepts.refine();
		});
		$('#clearBtn').on('click', function() {
			ftt.concepts.reset();
		});
		$('#icpcSearchBtn').on('click', function() {
			ftt.icpccodes.refine();
		});
		$('#icpcClearBtn').on('click', function() {
			ftt.icpccodes.reset();
		});

		// ICPC First button actions
		$('#icpcSearchBtn2').on('click', function() {
			ftt.icpccodesFirst.refine();
		});
		$('#icpcClearBtn2').on('click', function() {
			ftt.icpccodesFirst.reset();
		});

		$('#nextBtn').on('click', function(e) {
			e.preventDefault();
			$('#addAnother').val("false");
			$(this).closest('form').attr('action', 'add-hi.php').submit();
		});
		$('#finishedBtn').on('click', function(e) {
			e.preventDefault();
			$(this).closest('form').attr('action', 'review-encounter.php').submit();
		});
		$('.deleteItemBtn').on('click', function(e) {
			e.preventDefault();
			var $this = $(e.target);
			var wId = $this.attr('id').split('-')[1];
			var numThis = $this.closest('form').find('#numThis').val();
			var thisType = ($this.closest('form').find('#itemType').val().toString() === "0" ? "RFE" : "Health Issue");
			if (numThis < 2) {
				bootbox.alert('Each encounter must have at least one RFE and at least one Health Issue.');
			} else {
				bootbox.confirm("Delete " + thisType + " #" + wId + " - Are you sure?", function(result) {
					if (result) {
						// TODO: show some kind of spinner (spin.js) while this call is made
						$.ajax({
							url : 'deleteItem.php',
							type : 'POST',
							data : 'id=' + wId,
							success : function(response, textStatus, jqXHR) {
								bootbox.alert(thisType + " #" + wId + " successfully deleted.", function() {
									window.location.href = "review-encounter.php";
								})
							},
							error : function(jqXHR, textStatus, errorThrown) {
								alert('error: ' + errorThrown);
							}
						});
					}
				});
			}
		});
		$('.deleteEncounterBtn').on('click', function(e) {
			e.preventDefault();
			var $this = $(e.target);
			var wId = $this.attr('id').split('-')[1];
			bootbox.confirm("Delete Encounter #" + wId + " - Are you sure?", function(result) {
				if (result) {
					// TODO: show some kind of spinner (spin.js) while this call is made
					$.ajax({
						url : 'deleteEncounter.php',
						type : 'POST',
						data : 'id=' + wId,
						success : function(response, textStatus, jqXHR) {
							bootbox.alert("Encounter #" + wId + " successfully deleted.", function() {
								window.location.href = "index.php";
							});
						},
						error : function(jqXHR, textStatus, errorThrown) {
							alert('error: ' + errorThrown);
						}
					});
				}
			});
		});

		// setup js spinners to display before AJAX calls in itemsHolder on encounters list page
		$('.itemsHolder .spin').each(function() {
			var $this = $(this);
			var spinner = new Spinner(ftt.spinOpts).spin($this[0]);
		});

		// AJAX calls for on encounters list page
		$('.encounters-list .collapse').not('fetched').on('shown', function() {
			var $this = $(this), $container = $this.find('.itemsHolder'), wId = $container.attr('id').split('-')[1];

			$.ajax({
				url : 'getItems.php',
				type : 'POST',
				data : 'enc=' + wId,
				dataType : 'json',
				success : function(response, textStatus, jqXHR) {
					$this.addClass('fetched');
					var insertHtml = ftt.items.write(response);
					$container.empty().append(insertHtml);
				},
				error : function(jqXHR, textStatus, errorThrown) {
					alert('error: ' + errorThrown);
				}
			});
		});

		// scrollto and open encounter after label change
		if (($('.encounters-list').length > 0) && (window.location.search.indexOf('scrollTo') !== -1)) {
			var wId = window.location.search.split('scrollTo=')[1];
			var wX = $('#collapse' + wId).closest('.accordion-group').offset().top;
			window.scrollTo(0, wX);
			$('#collapse' + wId).parent().find('.accordion-toggle').trigger('click');
		}

		// trap pressing RETURN on add/edit form - send focus to search box
		$('form#addItem, form#editItem').bind('keypress', function(e) {
			if (e.keyCode === 13) {
				e.preventDefault();
				$('#searchBox').focus();
			}
		});
		// if already in SCT search box, RETURN triggers search
		$('#searchBox').bind('keypress', function(e) {
			if (e.keyCode === 13) {
				e.preventDefault();
				$('#searchBtn').click();
			}
		});
		// if already in ICPC search box, RETURN triggers search
		$('#icpcSearchBox').bind('keypress', function(e) {
			if (e.keyCode === 13) {
				e.preventDefault();
				$('#icpcSearchBox').click();
			}
		});

		// any keypress in alternative box triggers fields to be displayed
		$('#conceptFreeText').bind('keypress', function(e) {
			var altText = $('#conceptFreeText').val();
			if (altText != '') {
				$('#ICPC-Code').show();
				$('#ActionButtons').show();
			}
		});
	},

	// icpcCode specific searches and result displays
	icpccodes : {
		refine : function() {
			var searchText = $('#icpcSearchBox').val();

			if (searchText == '') {
				$('#icpcDropdown, #icpcClearBtn').hide();
				$('#icpcDropdown')[0].selectedIndex = 0;
				$('#icpcDropdown').unbind('change');
			} else {
				$.ajax({
					url : 'searchICPC.php',
					type : 'POST',
					data : 'searchText=' + searchText,
					dataType : 'json',
					success : function(response, textStatus, jqXHR) {
						tools.rewriteICPCDropdown($('#icpcDropdown'), response);
						$('#icpcDropdown, #icpcClearBtn').show();
						$('#itemsHolder').show();
						$('#icpcDropdown').on('change', function() {
							$('#ActionButtons').show();
						});
					},
					error : function(jqXHR, textStatus, errorThrown) {
						alert('error: ' + errorThrown);
					}
				});
			}
		},

		reset : function() {
			$('#icpcSearchBox').val('');
			ftt.icpccodes.refine();
		},
	},

	// SCT concept specific searches and result displays
	concepts : {
		refine : function() {
			var searchText = $('#searchBox').val();
			var altText = $('#conceptFreeText').val();
			
			if ((searchText == '') && (altText == '')) {
				$('#ICPC-Code').hide();
				$('#addSameBtn').hide();
				$('#nextBtn').hide();
				$('#finishedBtn').hide();
				$('#itemsHolder').hide();
				$('#ActionButtons').hide();
				$('#conceptsDropdown')[0].selectedIndex = 0;
				$('#conceptsDropdown').unbind('change');
				$('#conceptsDropdown, dl.synonyms, #clearBtn, #icpcDropdown, #icpcClearBtn').hide();
			} else {
				$.ajax({
					url : 'searchConcepts.php',
					type : 'POST',
					data : 'searchText=' + searchText,
					dataType : 'json',
					success : function(response, textStatus, jqXHR) {
//						$('#conceptsDropdown').empty();
						tools.rewriteDropdown($('#conceptsDropdown'), response);
						$('#conceptsDropdown, #clearBtn').show();
						$('#itemsHolder').show();
						$('#conceptsDropdown').on('change', function() {
							$('#ActionButtons').show();
							ftt.concepts.getSynonyms();
							ftt.concepts.getICPC();
						});
						$('#icpcDropdown', '#icpcClearBtn').hide();
					},
					error : function(jqXHR, textStatus, errorThrown) {
						alert('error: ' + errorThrown);
					}
				});
			}
		},

		reset : function() {
			$('#searchBox').val('');
			ftt.concepts.refine();
		},
		getSynonyms : function() {
			var cid = $('#conceptsDropdown').val();
			
			$.ajax({
				url : 'getSynonyms.php',
				type : 'POST',
				data : 'syn=' + cid,
				dataType : 'json',
				success : function(response, textStatus, jqXHR) {
					ftt.concepts.showSynonyms(response);
				},
				error : function(jqXHR, textStatus, errorThrown) {
					alert('error: ' + errorThrown);
				}
			});
		},
		showSynonyms : function(data) {
			var str = '<ul>';
			for (var x = 0; x < data.length; x++) {
				str += '<li>' + data[x].synonym + '</li>';
			}
			str += '</ul>';
			$('#itemsHolder').hide();
			$('dl.synonyms dd').empty().append(str);
			$('dl.synonyms').show();
			$('#ICPC-Code').show();
		},

		getICPC : function() {
			var codeid = $('#conceptsDropdown').val();

			$.ajax({
				url : 'getICPC.php',
				type : 'POST',
				data : 'codeid=' + codeid,
				dataType : 'json',
				success : function(response, textStatus, jqXHR) {
					ftt.concepts.showICPC(response);
					$('#ActionButtons').show();
				},
				error : function(jqXHR, textStatus, errorThrown) {
					alert('error: getICPC - ' + errorThrown + ' ' + textStatus + ' ' + codeid);
				}
			});
		},

		showICPC : function(data) {
			var str = data[0].id + " - " + data[0].title;
			$('span.icpcCode').empty().append(str);
			$('#icpc2').val(data[0].id);
		},
	},

	// the following functions cover the ICPC first option
	// icpcCode specific searches and result displays

	icpccodesFirst : {
		refine : function() {
			var searchText = $('#icpcSearchBox').val();
			//			alert("search box val is - " + searchText);

			if (searchText == '') {
				$('#SCT-Code').hide();
				$('#ActionButtons').hide();
				$('#icpcDropdown')[0].selectedIndex = 0;
				$('#icpcDropdown').unbind('change');
				$('#icpcDropdown, #icpcClearBtn2').hide();
			} else {
				$.ajax({
					url : 'searchICPC.php',
					type : 'POST',
					data : 'searchText=' + searchText,
					dataType : 'json',
					success : function(response, textStatus, jqXHR) {
						tools.rewriteICPCDropdown($('#icpcDropdown'), response);
						$('#icpcDropdown, #icpcClearBtn2').show();
						$('#icpcDropdown').on('change', function() {
							ftt.icpccodesFirst.getSCTMap();
							$('#ActionButtons').hide();
						});
					},
					error : function(jqXHR, textStatus, errorThrown) {
						alert('error: ' + errorThrown);
					}
				});
			}
		},

		reset : function() {
			$('#icpcSearchBox').val('');
			ftt.icpccodesFirst.refine();
		},

		getSCTMap : function() {
			var codeid = $('#icpcDropdown').val();
			var refid = $('#refType').val();

			$.ajax({
				url : 'getSCTMap.php',
				type : 'POST',
				data : {
					codeid : codeid,
					refid : refid
				},
				dataType : 'json',
				success : function(response, textStatus, jqXHR) {
					$('#SCT-Code').show();
					$('#conceptsDropdown').show();
					tools.rewriteDropdown($('#conceptsDropdown'), response);
					$('#conceptsDropdown').on('change', function() {
						ftt.concepts.getSynonyms();
						$('#ActionButtons').show();
					});

				},
				error : function(jqXHR, textStatus, errorThrown) {
					alert('error: getSCTMap - ' + errorThrown + ' ' + textStatus + ' ' + codeid);
				}
			});
		},

		showSCT : function(data) {
			var str = '<ul>';

			for (var x = 0; x < data.length; x++) {
				str += '<li>' + data[x].id + ' - ' + data[x].title + '</li>';
			}
			str += '</ul>';
			$('dl.sct-mapped-concepts dd').empty().append(str);
		},
	},

	items : {
		write : function(data) {
			tools.dir(data);
			var str = '<dl class="dl-horizontal"><dt>Reason For Encounters</dt><dd><ul>';
			for (var x = 0; x < data.length; x++) {// RFEs only
				if (data[x].type === "0") {
					str += '<li>' + data[x].term + '</li>';
				}
			}
			str += '</ul></dd><dt>Health Issues</dt><dd><ul>';
			for (var y = 0; y < data.length; y++) {// HIs only
				if (data[y].type === "1") {
					str += '<li>' + data[y].term + '</li>';
				}
			}
			str += '</ul></dd></dl>';

			return str;
		}
	}
};

var tools = {
	// safe logging
	log : function(msg) {
		if (window && window.console) {
			console.log(msg);
		}
	},
	dir : function(obj) {
		if (window && window.console) {
			console.dir(obj);
		}
	},

	// SCT concept dropdown rebuilding from JSON
	rewriteDropdown : function($obj, data) {
		var $tmp = $obj.find('option')[0];
		$obj.empty().append($tmp);
		for (var x = 0; x < data.length; x++) {
			$obj.append('<option value="' + data[x].conceptId + '">' + data[x].term + '</option>');
		}
	},

	// ICPC Code dropdown rebuilding from JSON
	rewriteICPCDropdown : function($obj, data) {
		var $tmp = $obj.find('option')[0];
		$obj.empty().append($tmp);
		for (var x = 0; x < data.length; x++) {
			$obj.append('<option value="' + data[x].id + '">' + data[x].title + '</option>');
		}
	}
};

$(function() {
	ftt.init();
});
