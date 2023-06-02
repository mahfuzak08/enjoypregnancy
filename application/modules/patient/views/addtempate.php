<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">

            <header class="panel-heading">
                <?php echo lang('patient'); ?> <?php echo 'form template'; ?>
                
            </header>
            <div class="panel-body">
                <form action="<?= base_url() ?>patient/save_patient_template" method="post">
                    <div class="adv-tableX  ">

                        <div class="space15"></div>
                        <div class="form-group">
                            <label>Tempalte Name</label>
                            <input class="form-control" name="template">
                        </div>
                        <div class="col-md-7">

                            <div id="sectionArea">

                            </div>

                            <div class="space15"></div>

                            <div class="form-group">
                                <button class="btn btn-primary" id="AddSectionBtn" type="button">Add Section</button>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Save Template</button>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->


<script src="common/js/codearistos.min.js"></script>
<script>
    $(document).ready(function () {
        $.fn.addOptions = function (optionsType, section_index, index = 0) {

            var html = ''
            if (optionsType == 'SC') {
                html = '<div class="input-group">  <span class="input-group-addon">  <input type="radio"  >  </span>   ' +
                    '<input type="text" class="form-control"  name="section[' + section_index + '][quiz][' + index + '][ans][]">  <span class="input-group-btn"><button  type="button" class="btn btn-danger btn-flat deletebtn  " onclick="this.parentNode.parentNode.remove(this.parentNode);" ><i class="fa fa-trash"></i></button> </span> </div>  '
            }

            if (optionsType == 'MC') {
                html = '<div class="input-group">  <span class="input-group-addon">  <input type="checkbox" >  </span>  ' +
                    ' <input type="text" class="form-control" name="section[' + section_index + '][quiz][' + index + '][ans][]"> <span class="input-group-btn"> <button  type="button" class="btn btn-danger btn-flat deletebtn  " onclick="this.parentNode.parentNode.remove(this.parentNode);" ><i class="fa fa-trash"></i></button></span>  </div>  '
            }
            return optionHtml = '<div class="col-md-10 form-group">' + html + '</div>'

        }
        $.fn.addquiz = function (section_index, index = 0) {
            //var randIndex  =  Math.floor(Math.random() * 26) + Date.now();
            var qtytype = '<div class="panel-body sectionQuestion"> <button  type="button" class="btn btn-danger btn-flat deletebtn pull-right " onclick="this.parentNode.remove(this.parentNode);" >  Remove question</button> ' +
                ' <div class="form-group "><label>Question title </label> <input type="text" class="form-control" name="section[' + section_index + '][quiz][' + index + '][title]"> </div> '
            qtytype += '<div class="form-group "><label>Choose Type : </label> <select name="section[' + section_index + '][quiz][' + index + '][quize_type]"  class="form-control quize_type"  data-index="' + index + '" data-section_index="' + section_index + '">' +
                ' <option value="SLT">Single Line text</option>' +
                ' <option value="SC">Single Choice</option>  ' +
                '<option value="MC">Multiple Choice</option>' +
                ' <option value="PF">Paragraph Field</option>' +
                ' <option value="Signature">Signature</option>' +
                ' <option value="Attach">Attachment</option></select>' +
                '</div>' +
                '<div class="form-group"><label> Required?  </label> <input type="checkbox" name="section[' + section_index + '][quiz][' + index + '][required]" value="1"> </div><div class="SectionAnsOptions form-group"></div></div>';
            return qtytype;
        }

        $(document).on("click", "#AddSectionBtn", function () {
            var section_index = $('#sectionArea .sectionPanel').length+1;
            // alert(section_index)


            qtytype = $.fn.addquiz(section_index, 0);

            sectionHTML = '<div class="panel panel-info " style="border: 1px solid #dedede; padding-top: 0;">' +
                '<div class="panel-heading"  style="margin-top: 0;" > <div class="row">' +
                '<div class="col-md-8"> Section title <input type="text" class="form-control" name="section[' + section_index + '][title]"> </div> ' +
                '<div class="col-md-4 text-right"> <button  type="button" class="btn btn-danger btn-flat deletebtn  " onclick="this.parentNode.parentNode.parentNode.parentNode.remove(this.parentNode);" >  Remove Section</button>  </div>' +
                '</div> </div><div class="QuizArea" >' + qtytype + '</div>' +
                ' <div class="panel-footer"><button type="button" class="btn btn-default addQuizBtn" data-section_index="' + section_index + '"  >Add Question</button></div></div>'

            html = '<div class="sectionPanel">' + sectionHTML + '</div>'
            $('#sectionArea').append(html);
        })

        $(document).on("click", ".addQuizBtn", function () {
            section_index = Number($(this).data('section_index'))

            var quiz_field = $('.sectionQuestion').length + 1;

            var html = '<div class="border-top"></div>';
            html += $.fn.addquiz(section_index, quiz_field);

            $(this).parent().parent().find('.QuizArea').append(html);
            //  alert(quiz_field)
        })


        $(document).on("change", ".quize_type", function () {
            section_index = Number($(this).data('section_index'))
            optiontype = $(this).val()
            var quiz_field = Number($(this).data('index')); //$(this).find('.sectionQuestion').length +1;


            var htmlOption = '<div class="border-bottom"></div>';
            htmlOption += $.fn.addOptions(optiontype, section_index, quiz_field);
            if (optiontype == 'MC' || optiontype == 'SC') {
                htmlOption += '<div><button type="button" class="btn  btn-default addAnsBtn" data-optiontype="' + optiontype + '" data-section_index="' + section_index + '" data-quiz_field="' + quiz_field + '">Add answer</button></div>';
            }
            $(this).parent().parent().find('.SectionAnsOptions').html(htmlOption);
            // $(this).parent().parent().find('.SectionAnsOptions').append(htmlOption);
            //  alert(quiz_field)
        })

        $(document).on("click", ".addAnsBtn", function () {
            optiontype = $(this).data('optiontype');
            section_index = $(this).data('section_index');
            quiz_field = $(this).data('quiz_field');

            htmlOption = $.fn.addOptions(optiontype, section_index, quiz_field);

            $(this).parent().parent().parent().find('.SectionAnsOptions').append(htmlOption);
        })


    });
</script>



