import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
const $ = require('jquery');

$(document).ready(function (){

    const showCalendar = () => {

        const suiteSelection = $("#reservation_suite").val();
        const baseUrl = document.location.origin
        let calendarElt = document.getElementById("calendrier");

        calendarElt.classList.remove("hidden")

        if(suiteSelection){
            $.ajax({
                type:'GET',
                url: baseUrl + '/reservationsuite/'+ suiteSelection,
                dataType: "json",

            })
                .done(function(response){
                    const {data} = response
                    let calendar = new Calendar(calendarElt, {
                        plugins: [ dayGridPlugin, timeGridPlugin, listPlugin ],
                        initialView: 'dayGridMonth',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right:''
                        },
                        events:data
                    });
                    calendar.render();
                    // console.log(suiteSelection.val(),suiteSelection.text())
                    // if(data.length !== 0){
                    //     suiteSelection.slideDown(50);
                    // }else{
                    //     suiteSelection.slideUp(50);
                    // }
                })
                .fail(function(error){
                    console.log("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                })
        }else{
            calendarElt.classList.add("hidden");
        }
    }

    $("#reservation_suite").change(function(){
        showCalendar();
    })


})
