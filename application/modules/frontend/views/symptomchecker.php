<style>
.symptoms-div ul
{
    padding-left: 0px;
    margin: 0px;
}
.symptoms-div ul li
{
    list-style-type: none;
    margin-bottom: 10px;
}
.symptoms-div ul li.symptom a 
{
      font-size: 18px;
      border: 1px solid #b6b6b6;
      padding: 18px;
      line-height: 22px;
      min-height: 74px;
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
      color: #757575;
      display: block;
      max-width: 100%;
      position: relative;
      transition: all 0s ease-in-out!important;
      -moz-transition: all 0s ease-in-out!important;
      -webkit-transition: all 0s ease-in-out!important;
      -o-transition: all 0s ease-in-out!important;
  }
  .symptoms-div ul li.symptom a:after
  {
      content: ">";
      font-size: 30px;
      position: absolute;
      top: 50%;
      margin-top: -16px;
      right: 20px;
      color: #0098ff;
      display: inline-block;
  }
  .questions-div ul
  {
      padding-left: 0px;
      margin: 0px;

  }
  .questions-div ul li
  {
      list-style-type: none;
      margin-bottom: 10px;
      border: 1px solid #b6b6b6;
      padding: 18px;
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
  }
  .questions-div ul li p
  {
      font-size: 18px;
  }
  .symptoms-div ul li.symptom a:hover
  {
    background: #fff;
    color: #0098ff;
    border: 2px solid #0098ff;
  }
  .symptom-questions:hover
  {
    color: #0098ff;
    border: 2px solid #0098ff;
  }
  .symptom-questions:hover p
  {
    color: #0098ff;
  }
  .active-symptom
  {        
    color: #0098ff !important;
    border: 2px solid #0098ff !important; 
  }
  .active-answer
  {
    color: #0098ff !important;
    border: 2px solid #0098ff !important; 
  }
  .active-answer p
  {
    color: #0098ff !important;
  }
  .disabled-view
  {
      background: #f0f0f0;
      opacity: 0.6;
  }
  .disabled-view-div, .disabled-question-view-div, .disabled-answer-view-div
  {
    content: " ";
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: #f0f0f0;
    z-index: 9999;
    opacity: 0.6;
  }
</style>
<!-- Page Content -->
<div class="content">
<div class="container">
	<h2 class="text-center">Symptom Checker</h2>
	<h4 class="text-center">Tell us where it hurts.</h4>
    <div class="payment-widget">
        <div class="payment-list text-center">
            <label class="payment-radio paypal-option" style="display: inline-block;">
                <input type="radio" name="radio" value="adult" id="adult_radio" onclick="active_gender(1)" checked>
                <span class="checkmark"></span>
                Adult
            </label>
            &nbsp;&nbsp;
            <label class="payment-radio credit-card-option" style="display: inline-block;">
                <input type="radio" name="radio" value="child" id="child_radio" onclick="active_gender(2)">
                <span class="checkmark"></span>
                Child
            </label>
        </div>
    </div>
 <div class="row adult_div">
	<div class="col-lg-12 col-md-12 text-center">
	    <!-- <img src="uploads/imgpsh_fullsize_anim111.jpg" class="img-thumbnail"> -->
      <!-- Image Map Generated by http://www.image-map.net/ -->
      <img src="uploads/imgpsh_fullsize_anim111.jpg" usemap="#image-map" class="img-thumbnail">

      <map name="image-map">
          <area target="" alt="Head Front Male" title="Head Problems" href="javascript:void(0)" coords="58,23,91,39" shape="rect" data-symptom-name="Headaches">

          <area target="" alt="Neck Front Male" title="Neck Problems" href="javascript:void(0)" coords="65,65,85,70" shape="rect" data-symptom-name="Neck Pain">

          <area target="" alt="Shoulder Front Male" title="Shoulder Problems" href="javascript:void(0)" coords="36,70,110,81" shape="rect" data-symptom-name="Shoulder Problems">

          <area target="" alt="Chest Front Male" title="Chest Problems" href="javascript:void(0)" coords="47,84,102,113" shape="rect" data-symptom-name="Chest Pain, Acute">

          <area target="" alt="Right Arm Front Male" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="46,81,13,193" shape="rect" data-symptom-name="Hand/Wrist/Arm Problems">

          <area target="" alt="Left Arm Front Male" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="102,82,137,193" shape="rect" data-symptom-name="Hand/Wrist/Arm Problems">

          <area target="" alt="Abdomen Front Male" title="Abdomen Problems" href="javascript:void(0)" coords="50,114,99,156" shape="rect" data-symptom-name="Abdominal Pain (Stomach Pain), Long-term">

          <area target="" alt="Knee Problem Male" title="Knee Problems" href="javascript:void(0)" coords="49,227,101,244" shape="rect" data-symptom-name="Knee Problems">

          <area target="" alt="Right Leg Front Male" title="Leg Problems" href="javascript:void(0)" coords="49,188,74,297" shape="rect" data-symptom-name="Leg Problems">

          <area target="" alt="Left Leg Front Male" title="Leg Problems" href="javascript:void(0)" coords="76,188,100,297" shape="rect" data-symptom-name="Leg Problems">

          <area target="" alt="Foot Problem" title="Foot Problems" href="javascript:void(0)" coords="95,318,55,298" shape="rect" data-symptom-name="Foot Problems">

          <area target="" alt="Head Back Male" title="Head Problems" href="javascript:void(0)" coords="186,24,219,61" shape="rect" data-symptom-name="Headaches">

          <area target="" alt="Neck Back Male" title="Neck Problems" href="javascript:void(0)" coords="193,62,212,71" shape="rect" data-symptom-name="Neck Pain">

          <area target="" alt="Shoulder Back Male" title="Shoulder Problems" href="javascript:void(0)" coords="163,70,243,85" shape="rect" data-symptom-name="Shoulder Problems">

          <area target="" alt="Back right male" title="Back Problems" href="javascript:void(0)" coords="175,86,198,156" shape="rect" data-symptom-name="Lower Back Pain">

          <area target="" alt="Back left male" title="Back Problems" href="javascript:void(0)" coords="207,85,230,156" shape="rect" data-symptom-name="Lower Back Pain">

          <area target="" alt="Spin Male" title="Spin Problems" href="javascript:void(0)" coords="199,85,207,156" shape="rect">

          <area target="" alt="Left Back Arm Male" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="174,193,141,85" shape="rect" data-symptom-name="Hand/Wrist/Arm Problems">

          <area target="" alt="Right Back Arm Male" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="231,85,265,192" shape="rect" data-symptom-name="Hand/Wrist/Arm Problems">

          <area target="" alt="Knee Problem Back Male" title="Knee Problems" href="javascript:void(0)" coords="175,225,228,245" shape="rect" data-symptom-name="Knee Problems">

          <area target="" alt="Left Back Leg Male" title="Leg Problems" href="javascript:void(0)" coords="176,182,201,299" shape="rect" data-symptom-name="Leg Problems">

          <area target="" alt="Right Back Leg Male" title="Leg Problems" href="javascript:void(0)" coords="204,182,227,299" shape="rect" data-symptom-name="Leg Problems">

          <area target="" alt="Foot Problem" title="Foot Problems" href="javascript:void(0)" coords="182,300,224,315" shape="rect" data-symptom-name="Foot Problems">

          <area target="" alt="Genital Problem In Men" title="Genital Problems" href="javascript:void(0)" coords="65,157,88,177" shape="rect" data-symptom-name="Genital Problems in Men">

          <area target="" alt="Head Front Female" title="Head Problems" href="javascript:void(0)" coords="315,29,349,47" shape="rect" data-symptom-name="Headaches">

          <area target="" alt="Neck Front Female" title="Neck Problems" href="javascript:void(0)" coords="325,74,338,80" shape="rect" data-symptom-name="Neck Pain">

          <area target="" alt="Shoulder Front Female" title="Shoulder Problems" href="javascript:void(0)" coords="306,79,358,88" shape="rect" data-symptom-name="Shoulder Problems">

          <area target="" alt="Chest Front Female" title="Chest Problems" href="javascript:void(0)" coords="312,89,351,118" shape="rect" data-symptom-name="Chest Pain, Acute">

          <area target="" alt="Right Arm Front Female" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="307,84,301,95,277,183,294,188,302,153,308,136,310,116,310,99,309,90,312,89" shape="poly" data-symptom-name="Hand/Wrist/Arm Problems">

          <area target="" alt="Left Arm Front Female" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="352,90,353,114,354,130,369,191,385,184,359,88" shape="poly" data-symptom-name="Hand/Wrist/Arm Problems">

          <area target="" alt="Abdomen Front Female" title="Abdomen Problems" href="javascript:void(0)" coords="313,118,349,154" shape="rect" data-symptom-name="Abdominal Pain (Stomach Pain), Long-term">

          <area target="" alt="Knee Problem Front Female" title="Knee Problems" href="javascript:void(0)" coords="307,227,355,246" shape="rect" data-symptom-name="Knee Problems">

          <area target="" alt="Right Leg Front Female" title="Leg Problems" href="javascript:void(0)" coords="331,298,306,171" shape="rect" data-symptom-name="Leg Problems">

          <area target="" alt="Left Leg Front Female" title="Leg Problems" href="javascript:void(0)" coords="333,171,355,298" shape="rect" data-symptom-name="Leg Problems">

          <area target="" alt="Head Female Back" title="Head Problems" href="javascript:void(0)" coords="426,29,452,68" shape="rect" data-symptom-name="Headaches">
          <area target="" alt="Neck Female Back" title="Neck Problems" href="javascript:void(0)" coords="432,70,446,79" shape="rect" data-symptom-name="Neck Pain">

          <area target="" alt="Shoulder Back Female" title="Shoulder Problems" href="javascript:void(0)" coords="409,79,465,91" shape="rect" data-symptom-name="Shoulder Problems">

          <area target="" alt="Back Female Left" title="Back Problems" href="javascript:void(0)" coords="419,91,435,155" shape="rect" data-symptom-name="Lower Back Pain">

          <area target="" alt="Back Female Right" title="Back Problems" href="javascript:void(0)" coords="459,91,443,155" shape="rect" data-symptom-name="Lower Back Pain">

          <area target="" alt="Spin Female" title="Spin Problems" href="javascript:void(0)" coords="436,92,444,155" shape="rect">

          <area target="" alt="Right Arm Back Female" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="417,92,409,94,406,133,400,154,386,183,404,189,412,151,417,127,417,109" shape="poly" data-symptom-name="Hand/Wrist/Arm Problems">

          <area target="" alt="Left Arm Back Female" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="460,87,461,117,463,136,468,156,476,186,488,189,492,176,480,160,471,116,469,94" shape="poly" data-symptom-name="Hand/Wrist/Arm Problems">

          <area target="" alt="Knee Problem Back Female" title="Knee Problems" href="javascript:void(0)" coords="416,224,462,245" shape="rect" data-symptom-name="Knee Problems">

          <area target="" alt="Right Leg Back Female" title="Leg Problems" href="javascript:void(0)" coords="438,176,417,302" shape="rect" data-symptom-name="Leg Problems">

          <area target="" alt="Left Leg Back Female" title="Leg Problems" href="javascript:void(0)" coords="441,176,461,303" shape="rect" data-symptom-name="Leg Problems">

          <area target="" alt="Genital Problem In Women" title="Genital Problems" href="javascript:void(0)" coords="320,155,344,171" shape="rect" data-symptom-name="Genital Problems in Women">

          <area target="" alt="Foot Problem" title="Foot Problems" href="javascript:void(0)" coords="315,299,349,317" shape="rect" data-symptom-name="Foot Problems">
          <area target="" alt="Foot Problem" title="Foot Problems" href="javascript:void(0)" coords="423,303,457,315" shape="rect" data-symptom-name="Foot Problems">

          <area target="" alt="Eye Problem Male" title="Eye Problems" href="javascript:void(0)" coords="63,41,86,48" shape="rect" data-symptom-name="Eye Problems">

          <area target="" alt="Ear Left Problem Male" title="Ear Problems" href="javascript:void(0)" coords="61,55,57,42" shape="rect" data-symptom-name="Ear Problems">
          <area target="" alt="Ear Right Problem Male" title="Ear Problems" href="javascript:void(0)" coords="88,43,92,55" shape="rect" data-symptom-name="Ear Problems">

          <area target="" alt="Nose Problem" title="Nose Problems" href="javascript:void(0)" coords="79,54,70,49" shape="rect">
          <area target="" alt="Mouth Problem" title="Mouth Problems" href="javascript:void(0)" coords="68,56,82,61" shape="rect" data-symptom-name="Mouth Problems">

          <area target="" alt="Ear Problem Left Back Male" title="Ear Problems" href="javascript:void(0)" coords="184,41,190,53" shape="rect" data-symptom-name="Ear Problems">
          <area target="" alt="Ear Problem Right Back Male" title="Ear Problems" href="javascript:void(0)" coords="217,43,221,54" shape="rect" data-symptom-name="Ear Problems">

          <area target="" alt="Eye Problem Female" title="Eye Problems" href="javascript:void(0)" coords="320,50,343,57" shape="rect" data-symptom-name="Eye Problems">

          <area target="" alt="Nose Problem Female" title="Nose Problems" href="javascript:void(0)" coords="327,58,336,64" shape="rect">

          <area target="" alt="Ear Problem Left Female" title="Ear Problems" href="javascript:void(0)" coords="318,52,314,62" shape="rect" data-symptom-name="Ear Problems">
          <area target="" alt="Ear Problem Right Female" title="Ear Problems" href="javascript:void(0)" coords="345,52,349,63" shape="rect" data-symptom-name="Ear Problems">

          <area target="" alt="Mouth Problem Female" title="Mouth Problems" href="javascript:void(0)" coords="326,65,338,70" shape="rect" data-symptom-name="Mouth Problems">

          <area target="" alt="Ear Problem Left Back Female" title="Ear Problems" href="javascript:void(0)" coords="427,62,421,49" shape="rect" data-symptom-name="Ear Problems">
          <area target="" alt="Ear Problem Back Right Female" title="Ear Problems" href="javascript:void(0)" coords="450,50,458,62" shape="rect" data-symptom-name="Ear Problems">

          <area target="" alt="Hip Problem Front Left Male" title="Hip Problems" href="javascript:void(0)" coords="49,156,57,186" shape="rect" data-symptom-name="Hip Problems">
          <area target="" alt="Hip Problem Front Right Male" title="Hip Problems" href="javascript:void(0)" coords="93,157,100,187" shape="rect" data-symptom-name="Hip Problems">
          <area target="" alt="Hip Problem Back Right Male" title="Hip Problems" href="javascript:void(0)" coords="177,157,185,181" shape="rect" data-symptom-name="Hip Problems">
          <area target="" alt="Hip Problem Back Left Male" title="Hip Problems" href="javascript:void(0)" coords="219,157,228,181" shape="rect" data-symptom-name="Hip Problems">

          <area target="" alt="Hip Front Right Female" title="Hip Problems" href="javascript:void(0)" coords="307,149,316,171" shape="rect" data-symptom-name="Hip Problems">
          <area target="" alt="Hip Front Left Female" title="Hip Problems" href="javascript:void(0)" coords="349,147,357,170" shape="rect" data-symptom-name="Hip Problems">

          <area target="" alt="Hip Back Left Female" title="Hip Problems" href="javascript:void(0)" coords="412,155,426,175" shape="rect" data-symptom-name="Hip Problems">
          <area target="" alt="Hip Back Right Female" title="Hip Problems" href="javascript:void(0)" coords="452,155,464,175" shape="rect" data-symptom-name="Hip Problems">

      </map>
	</div>
  </div>
  <div class="row child_div" style="display: none;">
    <div class="col-lg-12 col-md-12 text-center">
        <!-- <img src="uploads/childcheckerimage.jpg" class="img-thumbnail"> -->
        <!-- Image Map Generated by http://www.image-map.net/ -->
        <img src="uploads/childcheckerimage.jpg" usemap="#image-map2" class="img-thumbnail">

        <map name="image-map2">
        <area target="" alt="Head Front child Male" title="Head Problems" href="javascript:void(0)" coords="34,37,102,70" shape="rect" data-symptom-name="Headaches">

        <area target="" alt="Neck Front Child Male" title="Neck Problems" href="javascript:void(0)" coords="63,111,76,118" shape="rect" data-symptom-name="Neck Pain">

        <area target="" alt="Shoulder Front Child Male" title="Shoulder Problems" href="javascript:void(0)" coords="45,118,94,125" shape="rect" data-symptom-name="Shoulder Problems">

        <area target="" alt="Chest Front Child Male" title="Chest Problems" href="javascript:void(0)" coords="51,126,88,144" shape="rect" data-symptom-name="Chest Pain in Infants and Children">

        <area target="" alt="Right Arm Front Child Male" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="50,124,14,182" shape="rect" data-symptom-name="Hand/Wrist/Arm Problems">

        <area target="" alt="Left Arm Front Child Male" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="89,125,125,183" shape="rect" data-symptom-name="Hand/Wrist/Arm Problems">

        <area target="" alt="Abdomen Front Child Male" title="Abdomen Problems" href="javascript:void(0)" coords="52,144,87,170" shape="rect" data-symptom-name="Abdominal Pain (Stomach Pain), Long-term">

        <area target="" alt="Knee Problem Front Child Male" title="Knee Problems" href="javascript:void(0)" coords="51,205,88,219" shape="rect" data-symptom-name="Knee Problems">

        <area target="" alt="Right Leg Front Child Male" title="Leg Problems" href="javascript:void(0)" coords="51,190,66,242" shape="rect" data-symptom-name="Leg Problems">

        <area target="" alt="Left Leg Front Child Male" title="Leg Problems" href="javascript:void(0)" coords="72,189,88,243" shape="rect" data-symptom-name="Leg Problems">

        <area target="" alt="Head Back Child Male" title="Head Problems" href="javascript:void(0)" coords="163,37,218,108" shape="rect" data-symptom-name="Headaches">

        <area target="" alt="Neck Back Child Male" title="Neck Problems" href="javascript:void(0)" coords="184,111,197,117" shape="rect" data-symptom-name="Neck Pain">

        <area target="" alt="Shoulder Back Child Male" title="Shoulder Problems" href="javascript:void(0)" coords="165,118,215,129" shape="rect" data-symptom-name="Shoulder Problems">

        <area target="" alt="Left Arm Back Child Male" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="169,129,135,182" shape="rect" data-symptom-name="Hand/Wrist/Arm Problems">

        <area target="" alt="Right Arm Back Child Male" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="210,128,245,182" shape="rect" data-symptom-name="Hand/Wrist/Arm Problems">

        <area target="" alt="Back Left Child Male" title="Back Problems" href="javascript:void(0)" coords="172,129,185,169" shape="rect" data-symptom-name="Lower Back Pain">

        <area target="" alt="Back Right Child Male" title="Back Problems" href="javascript:void(0)" coords="195,130,208,169" shape="rect" data-symptom-name="Lower Back Pain">

        <area target="" alt="Spin Child Male" title="Spin Problems" href="javascript:void(0)" coords="186,130,194,169" shape="rect">

        <area target="" alt="Knee Problem Back Child Male" title="Knee Problems" href="javascript:void(0)" coords="171,206,208,219" shape="rect" data-symptom-name="Knee Problems">

        <area target="" alt="Left Leg Back Child Male" title="Leg Problems" href="javascript:void(0)" coords="171,188,187,243" shape="rect" data-symptom-name="Leg Problems">

        <area target="" alt="Right Leg Back Child Male" title="Leg Problems" href="javascript:void(0)" coords="192,188,209,242" shape="rect" data-symptom-name="Leg Problems">

        <area target="" alt="Head Child Front Female" title="Head Problems" href="javascript:void(0)" coords="279,39,347,73" shape="rect" data-symptom-name="Headaches">

        <area target="" alt="Neck Front Child Female" title="Neck Problems" href="javascript:void(0)" coords="307,114,321,121" shape="rect" data-symptom-name="Neck Pain">

        <area target="" alt="Shoulder Front Child Female" title="Shoulder Problems" href="javascript:void(0)" coords="291,121,339,130" shape="rect" data-symptom-name="Shoulder Problems">

        <area target="" alt="Right Arm Front  Child Female" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="293,125,261,186" shape="rect" data-symptom-name="Hand/Wrist/Arm Problems">

        <area target="" alt="Left Arm Front  Child Female" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="334,130,369,185" shape="rect" data-symptom-name="Hand/Wrist/Arm Problems">

        <area target="" alt="Chest Front Child Female" title="Chest Problems" href="javascript:void(0)" coords="297,131,331,149" shape="rect" data-symptom-name="Chest Pain in Infants and Children">

        <area target="" alt="Abdomen Front Child Female" title="Abdomen Problems" href="javascript:void(0)" coords="297,150,332,172" shape="rect" data-symptom-name="Abdominal Pain (Stomach Pain), Long-term">

        <area target="" alt="Knee Problem Front Child Female" title="Knee Problems" href="javascript:void(0)" coords="295,205,332,218" shape="rect" data-symptom-name="Knee Problems">

        <area target="" alt="Right Leg Front Child Female" title="Leg Problems" href="javascript:void(0)" coords="295,187,311,242" shape="rect" data-symptom-name="Leg Problems">

        <area target="" alt="Left Leg Front Child Female" title="Leg Problems" href="javascript:void(0)" coords="318,187,332,240" shape="rect" data-symptom-name="Leg Problems">

        <area target="" alt="Head Back Child Female" title="Head Problems" href="javascript:void(0)" coords="404,39,462,107" shape="rect" data-symptom-name="Headaches">

        <area target="" alt="Neck Back Child Female" title="Neck Problems" href="javascript:void(0)" coords="425,111,441,121" shape="rect" data-symptom-name="Neck Pain">

        <area target="" alt="Shoulder Back Child Female" title="Shoulder Problems" href="javascript:void(0)" coords="406,120,461,131" shape="rect" data-symptom-name="Shoulder Problems">

        <area target="" alt="Back Left Child Female" title="Back Problems" href="javascript:void(0)" coords="415,132,429,172" shape="rect" data-symptom-name="Lower Back Pain">

        <area target="" alt="Back Right Child Female" title="Back Problems" href="javascript:void(0)" coords="439,131,451,172" shape="rect" data-symptom-name="Lower Back Pain">

        <area target="" alt="Spin Child Female" title="Spin Problems" href="javascript:void(0)" coords="430,132,438,172" shape="rect">

        <area target="" alt="Left Arm Back Child Female" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="412,131,380,186" shape="rect" data-symptom-name="Hand/Wrist/Arm Problems">

        <area target="" alt="Right Arm Back Child Female" title="Hand/Wrist/Arm Problems" href="javascript:void(0)" coords="454,132,487,186" shape="rect" data-symptom-name="Hand/Wrist/Arm Problems">

        <area target="" alt="Knee Problem Back Child Female" title="Knee Problems" href="javascript:void(0)" coords="416,205,451,218" shape="rect" data-symptom-name="Knee Problems">

        <area target="" alt="Left Leg Back Child Female" title="Leg Problems" href="javascript:void(0)" coords="415,187,430,240" shape="rect" data-symptom-name="Leg Problems">

        <area target="" alt="Right Leg Back Child Female" title="Leg Problems" href="javascript:void(0)" coords="437,187,452,239" shape="rect" data-symptom-name="Leg Problems">

        <area target="" alt="Hip Problem Left Front Child Male " title="Hip Problems" href="javascript:void(0)" coords="51,171,59,189" shape="rect" data-symptom-name="Hip Problems">

        <area target="" alt="Hip Problem Right Front Child Male " title="Hip Problems" href="javascript:void(0)" coords="79,170,87,189" shape="rect" data-symptom-name="Hip Problems">

        <area target="" alt="Genital Problem In Child Male" title="Genital Problems" href="javascript:void(0)" coords="62,170,75,180" shape="rect" data-symptom-name="Genital Problems in Infants (Male)">

        <area target="" alt="Hip Problem Left Back Child Male " title="Hip Problems" href="javascript:void(0)" coords="171,170,181,188" shape="rect" data-symptom-name="Hip Problems">

        <area target="" alt="Hip Problem Right Back Child Male " title="Hip Problems" href="javascript:void(0)" coords="199,170,208,189" shape="rect" data-symptom-name="Hip Problems">

        <area target="" alt="Foot Problem Front  Child Male " title="Foot Problems" href="javascript:void(0)" coords="43,242,98,254" shape="rect" data-symptom-name="Foot Problems">

        <area target="" alt="Foot Problem Back Child Male " title="Foot Problems" href="javascript:void(0)" coords="161,243,219,253" shape="rect" data-symptom-name="Foot Problems">

        <area target="" alt="Eye Problem Child Male" title="Eye Problems" href="javascript:void(0)" coords="58,88,51,87,48,79,53,73,62,74,70,75,87,74,93,83,85,90,75,82,66,80" shape="poly" data-symptom-name="Eye Problems">

        <area target="" alt="Nose Problem Child Male" title="Nose Problems" href="javascript:void(0)" coords="65,84,75,96" shape="rect">

        <area target="" alt="Mouth Problem Child Male" title="Mouth Problems" href="javascript:void(0)" coords="58,97,81,105" shape="rect" data-symptom-name="Mouth Problems">

        <area target="" alt="Ear Problem Right Front Child Male " title="Ear Problems" href="javascript:void(0)" coords="33,76,44,94" shape="rect" data-symptom-name="Ear Problems">

        <area target="" alt="Ear Problem Left Front Child Male " title="Ear Problems" href="javascript:void(0)" coords="95,77,106,94" shape="rect" data-symptom-name="Ear Problems">

        <area target="" alt="Ear Problem Left Back Child Male " title="Ear Problems" href="javascript:void(0)" coords="154,74,163,94" shape="rect" data-symptom-name="Ear Problems">

        <area target="" alt="Ear Problem Right Back Child Male " title="Ear Problems" href="javascript:void(0)" coords="219,77,227,94" shape="rect" data-symptom-name="Ear Problems">

        <area target="" alt="Ear Problem Right Front Child Female " title="Ear Problems" href="javascript:void(0)" coords="276,80,287,95" shape="rect" data-symptom-name="Ear Problems">

        <area target="" alt="Ear Problem Left Front Child Female " title="Ear Problems" href="javascript:void(0)" coords="341,82,351,96" shape="rect" data-symptom-name="Ear Problems">

        <area target="" alt="Eye Problem Female" title="Eye Problems" href="javascript:void(0)" coords="299,94,290,85,299,75,316,78,327,77,337,80,335,91,325,90,314,82" shape="poly" data-symptom-name="Eye Problems">

        <area target="" alt="Nose Problem Female" title="Nose Problems" href="javascript:void(0)" coords="309,87,319,98" shape="rect">

        <area target="" alt="Mouth Problem Female" title="Mouth Problems" href="javascript:void(0)" coords="303,98,326,107" shape="rect" data-symptom-name="Mouth Problems">

        <area target="" alt="Foot Problem Female Front" title="Foot Problems" href="javascript:void(0)" coords="285,241,345,254" shape="rect" data-symptom-name="Foot Problems">

        <area target="" alt="Hip Problem Right Front Female" title="Hip Problems" href="javascript:void(0)" coords="295,172,302,186" shape="rect" data-symptom-name="Hip Problems">

        <area target="" alt="Hip Problem Left Front Female" title="Hip Problems" href="javascript:void(0)" coords="326,172,332,187" shape="rect" data-symptom-name="Hip Problems">

        <area target="" alt="Ear Problem Left Back Child Female " title="Ear Problems" href="javascript:void(0)" coords="395,79,403,96" shape="rect" data-symptom-name="Ear Problems">

        <area target="" alt="Ear Problem Right Back Child Female " title="Ear Problems" href="javascript:void(0)" coords="463,81,471,96" shape="rect" data-symptom-name="Ear Problems">

        <area target="" alt="Foot Problem Back Female" title="Foot Problems" href="javascript:void(0)" coords="405,239,461,253" shape="rect" data-symptom-name="Foot Problems">

        <area target="" alt="Hip Problem Back Left Female" title="Hip Problems" href="javascript:void(0)" coords="416,173,423,186" shape="rect" data-symptom-name="Hip Problems">

        <area target="" alt="Hip Problem Back Right Female" title="Hip Problems" href="javascript:void(0)" coords="444,173,451,186" shape="rect" data-symptom-name="Hip Problems">

        <area target="" alt="Genital Problem In Child Female" title="Genital Problems" href="javascript:void(0)" coords="307,173,321,186" shape="rect" data-symptom-name="Genital Problems in Infants (Female)">

    </map>
    </div>
  </div>
  <br>
  
	  <div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="row">
			    <div class="col-md-4">                    
			        <div class="blog-view">                      
					  <div class="blog blog-single-post symptoms-blog">
                        <div class="disabled-view-div" style="display: none;"></div>
						<div class="blog-content">
							<h4><span class="badge badge-info">STEP 1</span></h4>
							<h3>Selecting A Symptom</h3>
							<div class="symptoms-div">
							    <ul class="symptom-wrap symptoms_list">
                    <?php foreach($symptoms_data as $value){ ?>
                    <li class="symptom"><a href="javascript:void(0)" class="<?php echo str_replace(array(' ',','), '', preg_replace('/[^A-Za-z ]/', '', $value->symptoms)); ?>" data-symptom-id="<?php echo $value->id; ?>" data-symptom-name="<?php echo $value->symptoms; ?>" title="<?php echo $value->symptoms; ?>"><?php echo $value->symptoms; ?></a></li>
                    <?php } ?>                                                
                  </ul>
							</div>
						</div>
					 </div>
					</div>
			    </div>
			    <div class="col-md-4" id="questions-main-div">
			        <div class="blog-view">
					  <div class="blog blog-single-post questions-blog disabled-view">
                        <div class="disabled-question-view-div" style="display: none;"></div>
						<div class="blog-content">
							<h4><span class="badge badge-primary">STEP 2</span></h4>
							<h3>Answering Questions</h3>
                            <div class="text-center question-loader" style="display: none;">
                                <img src="uploads/loader-image.gif" class="img-responsive">
                            </div>
                            <div class="questions-div">

                            </div>
						</div>
					 </div>
					</div>
			    </div>
			    <div class="col-md-4" id="answers-main-div">
			        <div class="blog-view">
					  <div class="blog blog-single-post answers-blog disabled-view">
                        <div class="disabled-answer-view-div" style="display: none;"></div>
						<div class="blog-content">
							<h4><span class="badge badge-success">STEP 3</span></h4>
							<h3>Possible Causes</h3>
                            <div class="text-center answers-loader" style="display: none;">
                                <img src="uploads/loader-image.gif" class="img-responsive">
                            </div>
                            <div class="answers-div">

                            </div>
						</div>
					 </div>
					</div>
			    </div>
			</div>
		</div>
     </div>
	</div>

</div>		
<!-- /Page Content -->

<!-- symptom cheker js code by Haseen-->
<script type="text/javascript" src="<?php echo base_url(); ?>uploads/jquery.rwdImageMaps.js"></script>
<script type="text/javascript">
$('body').on('click', 'map area', function(){
  var symptom_name = $(this).data('symptom-name');
  var strhere = symptom_name.replace(/\s/g,'').replace(/[^a-zA-Z ]/g, "");
  $('.symptoms_list').find('.'+strhere).click();
  console.log(strhere); return;
});
// $('img[usemap]').rwdImageMaps();
$('body').on('click', '.symptom a', function(){
  // alert(123); return;
    $('.symptom a').each(function(){
        $(this).removeClass('active-symptom');
    });
    $(this).addClass('active-symptom');
    var symptom_name = $(this).data('symptom-name');
    $.ajax({
        url:'frontend/getquestionsbyName',
        method:'GET',
        data:'symptom_name='+symptom_name,
        cache: false,
        beforeSend: function()
        {
            $('.questions-div').html('');
            $('.question-loader').fadeIn('slow');
        },
        success: function(result)
        {
            $('.question-loader').fadeOut('slow');
            $('.questions-blog').removeClass('disabled-view');
            $('.symptoms-blog .disabled-view-div').fadeIn('slow');
            $('.questions-blog .disabled-question-view-div').fadeOut('slow');
            // console.log(result);
            $('.questions-div').html(result);
            $("html, body").animate({ scrollTop: $('#questions-main-div').offset().top }, 1000);
        }
    });
  
});

$('.symptoms-blog .disabled-view-div').click(function(){
    $('.disabled-view-div').fadeOut('slow');
    $('.disabled-question-view-div').fadeIn('slow');
    $('.disabled-answer-view-div').fadeIn('slow');
    // $('.questions-blog').addClass('disabled-view');
    $('.questions-div').html('');
    $('.answers-div').html('');
});

$('.questions-blog .disabled-question-view-div').click(function(){
    $('.disabled-question-view-div').fadeOut('slow');
    $('.answers-blog').addClass('disabled-view');
    $('.answers-div').html('');
});

function startOver()
{
    $('.disabled-question-view-div').fadeOut('slow');
    $('.answers-blog').addClass('disabled-view');
    $('.answers-div').html('');
}
function noquestionbuton(val)
{
    $('.hide-show-'+val).fadeOut('slow');
}

function yesquestionbuton(val)
{
    $('.symptom-questions').each(function(){
        $(this).removeClass('active-answer');
    });
    $('.hide-show-'+val).addClass('active-answer');
    $.ajax({
        url:'frontend/getanswersbyId',
        method:'GET',
        data:'question_id='+val,
        cache: false,
        beforeSend: function()
        {
            $('.answers-div').html('');
            $('.answers-loader').fadeIn('slow');
        },
        success: function(result)
        {
            $('.answers-loader').fadeOut('slow');
            $('.answers-blog').removeClass('disabled-view');
            $('.questions-blog .disabled-question-view-div').fadeIn('slow');
            $('.disabled-answer-view-div').fadeOut('slow');
            // console.log(result);
            $('.answers-div').html(result);
            $("html, body").animate({ scrollTop: $('#answers-main-div').offset().top }, 1000);
        }
    });
}

function active_gender(val)
{
    if(val==1)
    {
        $('#adult_radio').prop('checked', true);
        $('.adult_div').fadeIn('slow');
        $('.child_div').fadeOut('slow');

        $.ajax({
          url:'frontend/getsymptomsByType',
          method:'GET',
          data:'type=Adult',
          cache:false,
          success:function(result)
          {
             $('.symptoms_list').html(result);
             $('.symptoms-blog .disabled-view-div').click();
          }
        });
    }

    if(val==2)
    {
        $('#child_radio').prop('checked', true);
        $('.adult_div').fadeOut('slow');
        $('.child_div').fadeIn('slow');
        $.ajax({
          url:'frontend/getsymptomsByType',
          method:'GET',
          data:'type=Child',
          cache:false,
          success:function(result)
          {
             $('.symptoms_list').html(result);
             $('.symptoms-blog .disabled-view-div').click();
          }
        });
    }
}

</script>
<!-- End here -->
   