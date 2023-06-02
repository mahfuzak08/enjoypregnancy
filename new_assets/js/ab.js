var filtering = false;
var x = "";

function visite_page(page){
  // $("#help_video_box #video_source").attr("src", "");
  if (typeof(Storage) !== "undefined") {
    if(page == 'login'){
      let mvh = localStorage.getItem("visite_history_maulaji_login");
      if(mvh == null || mvh == 0){
        $("#video_player_div").html('');
        $("#help_video_box_label").text("How to Register");
		$("#video_player_div").html('<video style="max-width:100%" controls id="video_player"><source src="https://maulaji.com/videos/DoctorSignup.mp4" type="video/mp4" id="video_source">Your browser does not support HTML video.</video>');
        $("#help_video_box").modal("show");
        localStorage.setItem("visite_history_maulaji_login", "1");
		x = document.getElementById("video_player"); 
      }
    }
  } else {
    console.log("Sorry, your browser does not support Web Storage...");
  }
}

$(".video_help").click(function(){
	$("#video_player_div").html('');
	$("#help_video_box_label").text($(this).attr("data-title"));
	$("#video_player_div").html('<video style="max-width:100%" controls id="video_player"><source src="'+ $(this).attr("data-link") +'" type="video/mp4" id="video_source">Your browser does not support HTML video.</video>');
	$("#help_video_box").modal("show");
	
	x = document.getElementById("video_player"); 
});

function pauseVid() { 
	x.pause();
	setTimeout(function(){
		x.remove();
		$("#video_player_div").html('');
	}, 200);
	$("#help_video_box").modal("hide");
} 

function search_faq(){
	var str = $("#faq_search").val().toLowerCase();
	
	$.each($(".faq-content li"), function(k, v){
		if($(v).text().toLowerCase().indexOf(str) > -1)
			$(v).show();
		else
			$(v).hide();
	});
}

function show_specialist(v, speciality, g){
	if(g != "") filtering = true;
	
	if(speciality.length > 0){
		filtering = true;
		$.each(speciality, function(k, value){
			if(g != ""){
				if($(v).hasClass(value) && $(v).hasClass(g)){
					$(v).fadeIn('slow');
				}
			}else{
				if($(v).hasClass(value)){
					$(v).fadeIn('slow');
				}
			}
		});
	}else{
		if($(v).hasClass(g)){
			$(v).fadeIn('slow');
		}
	}
}
function show_doctor_or_not(v, speciality, need_gender_checking){
	if(need_gender_checking){
		// male is checked
		if($("#gender_male").prop('checked')){
			show_specialist(v, speciality, 'male');
		}
		// female is checked
		else{
			show_specialist(v, speciality, 'female');
		}
	}
	else{
		show_specialist(v, speciality, '');
	}
}


function getZone() {
  function z(n){return (n<10? '0' : '') + n}
  var offset = new Date().getTimezoneOffset();
  var sign = offset < 0? '+' : '-';
  offset = Math.abs(offset);
  return sign + z(offset/60 | 0) + z(offset%60);
}

$(document).ready(function(){
	$('#terms_accept').click(function() {
		if ($(this).is(':checked')) {
			$('.submit-btn').removeAttr('disabled').removeClass('btn-light').addClass('btn-primary');
		} else {
			$('.submit-btn').attr('disabled', 'disabled').removeClass('btn-primary').addClass('btn-light');
		}
	});
	
	$(".alert").fadeTo(5000, 500).slideUp(500, function(){
		$("#success-alert").slideUp(500);
	});
	
	


	if($("#zone").length == 1){
		$("#zone").val(getZone());
		$("#zone_abbr").val(Intl.DateTimeFormat().resolvedOptions().timeZone);
	}
	// filter code
	$('input:checkbox').click(function(e){
		filtering = false;
		let speciality = [];
		$('.filter-checkboxes :input').each(function(){
			let item = $(this).val();
			if($(this).is(':checked')) 
				speciality.push(item);
		});
		$('.doctor-cards').fadeOut('slow');
		let need_gender_checking = $("#gender_male").prop('checked') != $("#gender_female").prop('checked');
		$.each($('.doctor-cards'), function(k, v){
			show_doctor_or_not(v, speciality, need_gender_checking);
		});
		if(filtering === false){
			$('.doctor-cards').fadeIn('show');
		}          
	});
	
	$("#hospital").on("keyup focus", function() {
        $('#hospitallist').fadeIn('slow');
		var value = $(this).val().toLowerCase();
        $("#hospitallist li").filter(function() {
			// if the country or city are selected, then only virtual hospital will be show now.
			// because hospital are not country/ city wise. I'll change it soon.
			if($("#country").val() != "" || $("#city").val() != "")
				$(this).toggle($(this).text().indexOf('Virtual') > -1)
			else
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
	});
	
	// demo data
	//BMI Status
	if($('#bmi-status').length > 0) {
		var options = {
          series: [{
            name: "BMI",
            data: bmi
        }],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: history_date,
        }
        };

        var chart = new ApexCharts(document.querySelector("#bmi-status"), options);
        chart.render();
	}

	//Heart Rate Status
	if($('#heartrate-status').length > 0) {
		var options = {
          series: [{
          name: 'HeartRate',
          data: heart_rate
        }],
          chart: {
          height: 350,
          type: 'line',
        },
        stroke: {
          width: 7,
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
          categories: history_date,
          tickAmount: 10,
        },
        title: {
          align: 'left',
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            gradientToColors: [ '#0de0fe'],
            shadeIntensity: 1,
            type: 'horizontal',
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
          },
        },
        markers: {
          size: 4,
          colors: ["#15558d"],
          strokeColors: "#fff",
          strokeWidth: 2,
          hover: {
            size: 7,
          }
        },
        yaxis: {
          min: -10,
          max: 40,
          title: {
          },
        }
        };

        var chart = new ApexCharts(document.querySelector("#heartrate-status"), options);
        chart.render();
	}
	
	//Respiratory Rate Status
	if($('#resrate-status').length > 0) {
		var options = {
          series: [{
          name: 'Respiratory Rate',
          data: respiratory_rate
        }],
          chart: {
          height: 350,
          type: 'line',
        },
        stroke: {
          width: 7,
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
          categories: history_date,
          tickAmount: 10,
        },
        title: {
          align: 'left',
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            gradientToColors: [ '#0de0fe'],
            shadeIntensity: 1,
            type: 'horizontal',
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
          },
        },
        markers: {
          size: 4,
          colors: ["#15558d"],
          strokeColors: "#fff",
          strokeWidth: 2,
          hover: {
            size: 7,
          }
        },
        yaxis: {
          min: -10,
          max: 40,
          title: {
          },
        }
        };

        var chart = new ApexCharts(document.querySelector("#resrate-status"), options);
        chart.render();
	}
	
	//Temperature Status
	if($('#temperature-status').length > 0) {
		var options = {
          series: [{
          name: 'Temperature Status',
          data: temperature
        }],
          chart: {
          height: 350,
          type: 'line',
        },
        stroke: {
          width: 7,
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
          categories: history_date,
          tickAmount: 10,
        },
        title: {
          align: 'left',
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            gradientToColors: [ '#0de0fe'],
            shadeIntensity: 1,
            type: 'horizontal',
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
          },
        },
        markers: {
          size: 4,
          colors: ["#15558d"],
          strokeColors: "#fff",
          strokeWidth: 2,
          hover: {
            size: 7,
          }
        },
        yaxis: {
          min: -10,
          max: 40,
          title: {
          },
        }
        };

        var chart = new ApexCharts(document.querySelector("#temperature-status"), options);
        chart.render();
	}
	
	//Blood Pressure Status
	if($('#bp-status').length > 0) {
		var options = {
          series: [{
          name: 'Blood Pressure Status',
          data: blood_pressure
        }],
          chart: {
          height: 350,
          type: 'line',
        },
        stroke: {
          width: 7,
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
          categories: history_date,
          tickAmount: 10,
        },
        title: {
          align: 'left',
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            gradientToColors: [ '#0de0fe'],
            shadeIntensity: 1,
            type: 'horizontal',
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
          },
        },
        markers: {
          size: 4,
          colors: ["#15558d"],
          strokeColors: "#fff",
          strokeWidth: 2,
          hover: {
            size: 7,
          }
        },
        yaxis: {
          min: -10,
          max: 40,
          title: {
          },
        }
        };

        var chart = new ApexCharts(document.querySelector("#bp-status"), options);
        chart.render();
	}

	//FBC Status
	if($('#fbc-status').length > 0) {
	 	var options = {
          series: [{
          name: 'FBC',
          data: fbc
        }],
          chart: {
          height: 350,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val + "%";
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        
        xaxis: {
          categories: history_date,
          position: 'top',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#0de0fe',
                colorTo: '#0de0fe',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return val + "%";
            }
          }
        
        },
        title: {
          floating: true,
          offsetY: 330,
          align: 'center',
          style: {
            color: '#444'
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#fbc-status"), options);
        chart.render();
    }

	//Vaccination Status
	// if($('#vaccination-status').length > 0) {
	 	// var options = {
          // series: [{
          // name: 'Vaccination',
          // data: vaccination
        // }],
          // chart: {
          // height: 350,
          // type: 'bar',
        // },
        // plotOptions: {
          // bar: {
            // borderRadius: 10,
            // dataLabels: {
              // position: 'top', // top, center, bottom
            // },
          // }
        // },
        // dataLabels: {
          // enabled: true,
          // formatter: function (val) {
            // return val + "%";
          // },
          // offsetY: -20,
          // style: {
            // fontSize: '12px',
            // colors: ["#304758"]
          // }
        // },
        
        // xaxis: {
          // categories: history_date,
          // position: 'top',
          // axisBorder: {
            // show: false
          // },
          // axisTicks: {
            // show: false
          // },
          // crosshairs: {
            // fill: {
              // type: 'gradient',
              // gradient: {
                // colorFrom: '#0de0fe',
                // colorTo: '#0de0fe',
                // stops: [0, 100],
                // opacityFrom: 0.4,
                // opacityTo: 0.5,
              // }
            // }
          // },
          // tooltip: {
            // enabled: true,
          // }
        // },
        // yaxis: {
          // axisBorder: {
            // show: false
          // },
          // axisTicks: {
            // show: false,
          // },
          // labels: {
            // show: false,
            // formatter: function (val) {
              // return val + "%";
            // }
          // }
        
        // },
        // title: {
          // floating: true,
          // offsetY: 330,
          // align: 'center',
          // style: {
            // color: '#444'
          // }
        // }
        // };

        // var chart = new ApexCharts(document.querySelector("#vaccination-status"), options);
        // chart.render();
    // }

    //Weight Status
    if($('#weight-status').length > 0) {
    	var options = {
          series: [{
          name: 'Weight',
          data: weight
        }],
          chart: {
          type: 'line',
          height: 350
        },
        stroke: {
          curve: 'stepline',
        },
        dataLabels: {
          enabled: false
        },
        title: {
          align: 'left'
        },
        markers: {
          hover: {
            sizeOffset: 4
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#weight-status"), options);
        chart.render();
    }
});