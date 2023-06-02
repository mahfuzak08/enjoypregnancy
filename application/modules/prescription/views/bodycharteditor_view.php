<!--sidebar end-->
<!--main content start-->


<link href="common/css/body_template.css?" rel="stylesheet"/>
<script src="common/js/codearistos.min.js"></script>

<!-- scripts -->

<script src="common/js/bootstrap-colorselector.js"></script>

<script>

    $(document).ready(function () {

        var activeBtn  ;
        $('.toolBoxitem').click(function () {



             activeBtn = $(this).data('item');

            $(this).addClass('.active')

           if(activeBtn == 'hand' || activeBtn == 'pen' || activeBtn == 'eraser') {
               $('.editarea canvas').removeClass('hand')
               $('.editarea canvas').removeClass('pen')
               $('.editarea canvas').removeClass('eraser')
               $('.editarea canvas').addClass(activeBtn)
           }

        })




        $(document).on("click", "#addtemplate", function () {

            $('#myModal2').modal('show');

        });

        $(document).on("click", ".thumbnails", function (e) {
            var img = $(this).data('img');

            // $('.editcontent').css('background', 'url(' + img + ')  no-repeat center');


            $('#myModal2').modal('hide');

        });

        //var imgcanvas = document.getElementById("imagecanvas");
       // var imgctx = imgcanvas.getContext("2d");

        $.loadImage = function (imageUrl) {

            // GET THE IMAGE.
            var img = new Image();
            img.src = imageUrl;

            // WAIT TILL IMAGE IS LOADED.
            img.onload = function () {

                fill_canvas(img);       // FILL THE CANVAS WITH THE IMAGE.
            }

            function fill_canvas(img) {
                // CREATE CANVAS CONTEXT.
                temimage = img
                area_height = screen.height - 200;

                area_width =  ( area_height * img.width )/  img.height


                canvas.width = area_width;
                canvas.height = area_height;

                var scale = Math.max(canvas.width / img.width, canvas.height / img.height);

                var x = (canvas.width / 2) - (img.width / 2) * scale;
                var y = (canvas.height / 2) - (img.height / 2) * scale;

                 //canvas.width = img.width;
                // canvas.height = img.height;
                ctx.drawImage(img, x, y, img.width * scale, img.height * scale);       // DRAW THE IMAGE TO THE CANVAS.

                //imgcanvas.width = area_width;
               // imgcanvas.height = area_height;
               // imgctx.drawImage(temimage, x, y, img.width * scale, img.height * scale);


                $("#editcanvas").width(area_width)
                $("#editcanvas").height(area_height)
             //   $("#editcanvas").css("background-image","url("+ imageUrl +")");
            }
        }
        //////load Body Image template/////
        $.loadImage('<?=base_url( 'common/' . $template->image)?>');
        //////////////////Marge Canvas////////////////

////////////////////////////////ownload Image///////////////////////////////////////
        function save(e) {
            ////////marge 2 canvas///////////
                [canvas].forEach(function(n) {
                imgctx.beginPath();
                imgctx.drawImage(n, 0, 0, canvas.width, canvas.height);
            });

           ////end marge////////////////
            const data = board.toDataURL('image/png');
            const a = document.createElement('a');
            a.href = data;
            a.download = 'image.png';
            a.click();
        }
///////////////////////////////////////////////////////////////////////////////////////////

        var canvas = document.getElementById("editcanvas");
        var ctx = canvas.getContext("2d");
        var lastX;
        var lastY;
        var mouseX;
        var mouseY;
        var canvasOffset = $("#editcanvas").offset();
        var offsetX = canvasOffset.left;
        var offsetY = canvasOffset.top;
        var isMouseDown = false;
        var brushSize = 3;
        var brushColor = "#ff0000";
        var points = [];
        var  redoStack =[];
        var tooltype = '';

        ////////////////////////////////////////////
        var board = document.getElementById("board");

        $("#resize").click(function(event){
            $("#editcanvas").width(area_width)
            $("#editcanvas").height(area_height)
        });

        $("#plus").click(function(event){

            $("#editcanvas").width(
                $("#editcanvas").width() * 1.5
            );

            $("#editcanvas").height(
                $("#editcanvas").height() * 1.5
            );

        });



        $("#minus").click(function(event){
            $("#editcanvas").width(
                $("#editcanvas").width() / 1.5
            );

            $("#editcanvas").height(
                $("#editcanvas").height() / 1.5
            );


        });






        
/////////////////////////////////////////////////////////////////////////////////////////////////
        canvas.onmousedown = function (e) {

            if (tooltype == 'text') {
                var coords = getCoords(canvas);
                var shiftX = e.pageX - coords.left;
                var shiftY = e.pageY - coords.top;

                // $('#addtext').x = shiftX
                $('textarea#textareaTest').remove();
                $('#saveText').remove();
                $('#textAreaPopUp').remove();
                if ($('#textAreaPopUp').length == 0) {
                    var mouseX = e.pageX - coords.left;
                    var mouseY = e.pageY - coords.top;
                    mx = mouseX;
                    my = mouseY;
                    //append a text area box to the canvas where the user clicked to enter in a comment
                    var textArea = "<div id='textAreaPopUp' style='position:absolute;top:" + mouseY + "px;left:" + mouseX + "px;z-index:30;'><textarea id='textareaTest' style='width:100px;height:50px;'    class='form-control' ></textarea>";
                    var saveButton = "<input type='button' value='save' id='saveText'  onclick='saveTextFromArea(" + mouseY + "," + mouseX + ");'></div>";
                    var appendString = textArea + saveButton;
                    $("#board").append(appendString);
                } else {
                    $('textarea#textareaTest').remove();
                    $('#saveText').remove();
                    $('#textAreaPopUp').remove();
                    //append a text area box to the canvas where the user clicked to enter in a comment
                    var textArea = "<div id='textAreaPopUp' style='position:absolute;top:" + mouseY + "px;left:" + mouseX + "px;z-index:30;'><textarea id='textareaTest' style='width:100px;height:50px;'    class='form-control' ></textarea>";
                    var saveButton = "<input type='button' value='save' id='saveText' onclick='saveTextFromArea(" + mouseY + "," + mouseX + ");'></div>";
                    var appendString = textArea + saveButton;
                    $("#board").append(appendString);
                }
            }
//////////////////////////////////////////////////////////////////////
            if (tooltype == 'hand') {

                var coords = getCoords(canvas);
                var shiftX = e.pageX - coords.left;
                var shiftY = e.pageY - coords.top;

                canvas.style.position = 'absolute';
              // document.body.appendChild(board);
              moveAt(e);

                canvas.style.zIndex = 1000; // над другими элементами


                function moveAt(e) {

                    canvas.style.left = e.pageX - shiftX + 'px';
                    canvas.style.top = e.pageY - shiftY + 'px';

                  //  newposX = e.pageX - shiftX  ;
                   // newposY = e.pageY - shiftY  ;


                    //$("#board").css("transform", "translate3d(" + newposX + "px," + newposY + "px,0px)");
                }

                document.onmousemove = function (e) {
                    if (tooltype == 'hand') {    moveAt(e); }
                };

                canvas.onmouseup = function () {
                    //document.body.removeAttr(board);

                    document.onmousemove = null;
                    canvas.onmouseup = null;
                };
            }
        }

        board.ondragstart = function () {
            return false;
        };

        function getCoords(elem) {   // кроме IE8-

                var box = elem.getBoundingClientRect();
                return {
                    top: box.top + pageYOffset,
                    left: box.left + pageXOffset
                };

        }

        $(document).on("click", "#saveText", function (e) {

            var text = $('textarea#textareaTest').val();
            $('textarea#textareaTest').remove();
            $('#saveText').remove();
            ctx.font = "28px Georgia";
            ctx.fillStyle = "fuchsia";
            //ctx.lineJoin = "round";
            ctx.fillText(text, mx, my);
//  ctx.drawText(font, fontsize, leftPlacement, topPlacement, text);
        })


        ///////////////////////////////////////////

        function handleMouseDown(e) {

            if(tooltype=='draw' || tooltype=='erase') {

                mouseX = parseInt(e.clientX - offsetX- 8);
                mouseY = parseInt(e.clientY -  offsetY   );

                // Put your mousedown stuff here

                ctx.beginPath();
                if (tooltype == 'draw') {
                    if (ctx.lineWidth != brushSize) {
                        ctx.lineWidth = brushSize;
                    }
                    if (ctx.strokeStyle != brushColor) {
                        ctx.strokeStyle = brushColor;
                    }

                    ctx.globalCompositeOperation = 'source-over';


                } else if (tooltype == 'erase') {
                    ctx.globalCompositeOperation = 'destination-out';
                    ctx.lineWidth = 6;
                }

                ctx.moveTo(mouseX, mouseY);
                points.push({x: mouseX, y: mouseY, size: brushSize, color: brushColor, mode: "begin"});
                lastX = mouseX;
                lastY = mouseY;
                isMouseDown = true;
            }
        }

        function handleMouseUp(e) {

            if(tooltype=='draw' || tooltype=='erase') {
                mouseX = parseInt(e.clientX - offsetX -8);
                mouseY = parseInt(e.clientY -  offsetY   );

                // Put your mouseup stuff here
                isMouseDown = false;
                points.push({x: mouseX, y: mouseY, size: brushSize, color: brushColor, mode: "end"});
            }
        }


        function handleMouseMove(e) {
            if(tooltype=='draw' || tooltype=='erase') {
                mouseX = parseInt(e.clientX - offsetX );
                mouseY = parseInt(e.clientY -  offsetY  );


                // Put your mousemove stuff here
                if (isMouseDown) {
                    ctx.lineTo(mouseX - 16, mouseY +5  );
                    ctx.stroke();
                    lastX = mouseX;
                    lastY = mouseY;
                    // command pattern stuff
                    points.push({x: mouseX, y: mouseY, size: brushSize, color: brushColor, mode: "draw"});
                }
            }
        }


        function redrawAll() {

            if (points.length == 0) {
                return;
            }

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            for (var i = 0; i < points.length; i++) {

                var pt = points[i];

                var begin = false;

                if (ctx.lineWidth != pt.size) {
                    ctx.lineWidth = pt.size;
                    begin = true;
                }
                if (ctx.strokeStyle != pt.color) {
                    ctx.strokeStyle = pt.color;
                    begin = true;
                }
                if (pt.mode == "begin" || begin) {
                    ctx.beginPath();
                    ctx.moveTo(pt.x, pt.y);
                }
                ctx.lineTo(pt.x, pt.y);
                if (pt.mode == "end" || (i == points.length - 1)) {
                    ctx.stroke();
                }
            }
            ctx.stroke();
        }

        function undoLast() {
            var lastPoint=points.pop();
            // add the "undone" point to a separate redo array
          redoStack.unshift(lastPoint);
            redrawAll();
        }
        function redoLast() {
            var lastPoint=redoStack.pop();
            // add the "undone" point to a separate redo array
            points.push(lastPoint);
            redrawAll();
        }
        // hold down the undo button to erase the last line segment
        var interval;
        $("#undo").mousedown(function () {
            interval = setInterval(undoLast, 10);
        }).mouseup(function () {
            clearInterval(interval);
        });

        $("#redo").mousedown(function () {
            interval = setInterval(redoLast, 10);
        }).mouseup(function () {
            clearInterval(interval);
        });
      /////////////////////////////////////////////////////////////

        ctx.lineJoin = "round";
        ctx.fillStyle = brushColor;
        ctx.lineWidth = brushSize;
        $("#save").click(function (e) {
            save(e);
        });


        $("#brush5").click(function () {
            brushSize = 5;
        });
        $("#brush10").click(function () {
            brushSize = 10;
        });
        // Important!  Brush colors must be defined in 6-digit hex format only
        $(".colorpickerbox li").click(function () {
            brushColor = $(this).data('color');
            $('.colorpickerbox').fadeToggle() ;
        });
        $("#brushBlue").click(function () {
            brushColor = "#0000ff";
        });

      $("#editcanvas").mousedown( function(e){  handleMouseDown(e);   });
        $("#editcanvas").mousemove(function(e){   handleMouseMove(e);} );
      $("#editcanvas").mouseup(function(e){ handleMouseUp(e);});




//Use draw|erase
        use_tool = function(tool) {
            tooltype = tool; //update
         // if(tooltype!='hand')   canvas = document.body.getElementsById(1); document.body.removeChild(canvas)
        }
////////////////////////////////SAve//////////////////
        $("#saveBtn").click(function(e) {
            e.preventDefault();

            var imgsrc = canvas.toDataURL("image/png");
                    console.log(imgsrc);

                    $("#newimg").attr('src', imgsrc);
                    $("#img").show();
                    var dataURL = canvas.toDataURL();

                    $.ajax({
                        type: "POST",
                        url: "<?=base_url()?>upload.php",
                        data: {
                            imgBase64: dataURL
                        }
                    }).done(function(obj) {
                      // alert(obj)
                       var img = '<img src="'+obj+'" class="img img-thumbnail" width="150">'
                        img += '<input type="hidden" name="template[]" value="'+obj+'">'
                                  // $('#bodyloader').append(img);
                       // $(".crossBtn").trigger('click')
                        window.opener.setData(img);
                        window.close();

                    });

        });
        $(".crossBtn").click(function(){   window.close(); })


       /* $(document).on("click mousemove",".editarea",function(e){
            if (tooltype == 'hand') {

                var x = e.clientX;
                var y = e.clientY;
                var newposX = x - offsetX;
                var newposY = y - offsetY;
                $("#board").css("transform", "translate3d(" + newposX + "px," + newposY + "px,0px)");
            }
        });*/

       /////////////////////color picker
        $('.colorpickerbox').hide();
        $('.colorpicker').click(function(){
            $('.colorpickerbox').fadeToggle() ;
        })



    })


</script>


<style>

     .arrow-left {
         width: 0px;
         height: 0px;
         border-top: 10px solid transparent;
         border-bottom: 10px solid transparent;
         border-right:10px solid white;
         position: absolute;
         left: -10px;
         top: 0px;
     }
    .colorpickerbox{
        position: relative;
           top: -35px;
           left:60px;
        background: #FFF;
        padding: 5px;
        border:1px solid #dedede ;
        width: 140px;
        z-index: 22;
    }
     .sienna{ background:  #A0522D } .indianred{ background:  #CD5C5C }  .orangered{ background:  #FF4500 } .darkcyan{ background:  #008B8B }
     .darkgoldenrod{ background:  #B8860B } .limegreen{ background:  #32CD32 } .gold{ background:  #FFD700 } .mediumturquoise{ background:  #48D1CC }

     .black{ background:  #000000 } .hotpink{ background:  #FF69B4 } .indianred{ background:  #CD5C5C } .lightskyblue{ background:  #87CEFA }
     .cornflowerblue{ background:  #6495ED } .crimson{ background:  #DC143C } .darkorange{ background:  #FF8C00 } .mediumvioletred{ background:  #C71585 }


     .colorpickerbox li:hover{ border: 1px solid #666664; cursor: pointer }


    .colorbox li{ display: inline-block; width: 20px; height: 20px; border: 1px solid #ededed; box-shadow: #0b97c4}
</style>

<section id="container">
    <section class=" ">
        <!-- page start-->
        <section class="row">


                <!--button class="btn btn-lg   " id="addtemplate">Add Template</button>-->
           <!--     <button class="btn green pull-right saveBtn pull-right" id="save">Download</button>-->


            <div class="panel col-md-12 templatearea">  <button class="btn green pull-right saveBtn pull-right" id="saveBtn">Save</button>
                <div class="">
                    <div class="col-lg-1">
                        <div class="toolbar ">
                            <ul class="list-unstyled">
                               <!-- <li>
                                    <button class="btn toolBoxitem btn-transparent" data-item="hand"  value="hand" onclick="use_tool('hand');"><i
                                                class="fal fa-hand-paper fa-2x"></i></button>
                                </li>-->
                                <li>
                                    <button class="btn toolBoxitem btn-transparent" id="pencil" data-item="pen" value="draw" onclick="use_tool('draw');"><i
                                                class="fal fa-pen fa-2x"></i></button>
                                </li>
                                <li>
                                    <button class="btn toolBoxitem btn-transparent" data-item="eraser"  value="erase" onclick="use_tool('erase');"><i
                                                class="fal fa-eraser  fa-2x"></i></button>
                                </li>
                                <li>
                                    <button class="btn toolBoxitem btn-transparent"  data-item="text"  value="text" onclick="use_tool('text');"><i
                                                class="fal fa-text  fa-2x"></i></button>
                                </li>
                                <li>
                                    <button class="btn toolBoxitem btn-transparent colorpicker"  data-item="pen" value="draw" onclick="use_tool('draw');" ><i
                                                class="fas fa-tint  text-danger fa-2x"></i></button>
                                    <div class="colorpickerbox"><span class="arrow-left"></span>
                                        <ul class="colorbox inline">
                                            <li value="106" data-color="#A0522D" class="sienna  "> </li>
                                            <li value="47" data-color="#CD5C5C"  class="indianred  " > </li>
                                            <li value="87" data-color="#FF4500" class="orangered  "> </li>
                                            <li value="17" data-color="#008B8B" class="darkcyan  "> </li>

                                            <li value="18" data-color="#B8860B" class="darkgoldenrod  "> </li>
                                            <li value="68" data-color="#32CD32" class="limegreen  "> </li>
                                            <li value="42" data-color="#FFD700" class="gold  "> </li>
                                            <li value="77" data-color="#48D1CC" class="mediumturquoise  "> </li>

                                            <li value="107" data-color="#87CEEB" class="black  "> </li>
                                            <li value="46" data-color="#FF69B4" class="hotpink  "> </li>
                                            <li value="47" data-color="#CD5C5C" class="indianred  "> </li>
                                            <li value="64" data-color="#87CEFA" class="lightskyblue  "> </li>

                                            <li value="13" data-color="#6495ED" class="cornflowerblue  "> </li>
                                            <li value="15" data-color="#DC143C" class="crimson  "> </li>
                                            <li value="24" data-color="#FF8C00" class="darkorange  "> </li>

                                        </ul>
                                    </div>
                                </li>

                                <li>
                                    <button class="btn  toolBoxitem btn-transparent" id="undo" data-item="undo"><i
                                                class="fal fa-undo-alt fa-2x"></i></button>
                                </li>
                              <!--  <li>
                                    <button class="btn  toolBoxitem btn-transparent"  id="redo" data-item="redo"><i
                                                class="fal fa-redo-alt fa-2x"></i></button>
                                </li>-->
                            </ul>
                            <ul class="list-unstyled my-5">
                                <li>
                                    <button class="btn  toolBoxitem" id="resize"><i class="fal fa-expand fa-2x"></i></button>
                                </li>
                                <li>
                                    <button class="btn toolBoxitem" id="plus"><i class="fal fa-search-plus fa-2x"></i></button>
                                </li>
                                <li>
                                    <button class="btn toolBoxitem" id="minus"><i class="fal fa-search-minus fa-2x"></i></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="editarea  col-lg-11">
                        <button class="btn btn-danger pull-right crossBtn" ><i class="fal fa-times-circle"></i></button>
                        <div id="board">
                            <canvas class="editcontent" id="editcanvas">  </canvas>
                          <!--  <canvas class="imagecanvas" id="imagecanvas">  </canvas>-->
                         </div>
                    </div>

                    <!--<button id="undo">Hold this button down to Undo</button>-->
                    <br><br>


                </div>

            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->


<!-- Edit Patient Modal-->
<!--<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> Add Template</h4>
            </div>
            <div class="modal-body row  ">

                <?php
/*                foreach ($template as $key => $item) {
                    */?>
                    <a href="javascript:;" data-img="<?/*= base_url('common/' . $item->image) */?>"
                       class="col-md-3 thumbnails text-center">
                        <img src="<?/*= base_url('common/' . $item->thumbnil) */?>"
                             class="img img-thumbnail img-responsive">
                        <h5> <?/*= $item->title; */?></h5>
                    </a>

                <?php /*} */?>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

-->
<script src="common/js/codearistos.min.js"></script>
<script src="common/js/jquery.js"></script>
<script src="common/js/jquery-1.8.3.min.js"></script>
<script src="common/js/bootstrap.min.js"></script>