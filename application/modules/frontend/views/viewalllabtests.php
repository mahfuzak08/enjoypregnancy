<!-- Page Content -->
<div class="content">
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="page-breadcrumb product-breadcrumb">
        <ol class="breadcrumb">
            <li class=""><a href="<?php echo base_url() ?>">Home</a></li>
            <li> / </li>
            <li class=""><a href="<?php echo base_url() ?>frontend/pharmacy">Laboratory</a></li>
            <li> / </li>                
            <li class="" aria-current="page">All Lab Tests</li>
        </ol>
    </nav>
    <br>

    <div class="row text-center">
        <div class="col-12">
            <h2> <b>All Lab Tests </b></h2>
            <p>Select one of the lab test below.</p>
        </div>
    </div>
</div>

<div class="col-12 text-center">    
  <ul class="appendix-list">
   <li> <a href="frontend/viewallLabTest#A">A</a></li>
   <li> <a href="frontend/viewallLabTest#B">B</a></li>
   <li> <a href="frontend/viewallLabTest#C">C</a></li>
   <li> <a href="frontend/viewallLabTest#D">D</a></li>
   <li> <a href="frontend/viewallLabTest#E">E</a></li>
   <li> <a href="frontend/viewallLabTest#F">F</a></li>
   <li> <a href="frontend/viewallLabTest#G">G</a></li>
   <li> <a href="frontend/viewallLabTest#H">H</a></li>
   <li> <a href="frontend/viewallLabTest#I">I</a></li>
   <li> <a href="frontend/viewallLabTest#J">J</a></li>
   <li> <a href="frontend/viewallLabTest#K">K</a></li>
   <li> <a href="frontend/viewallLabTest#L">L</a></li>
   <li> <a href="frontend/viewallLabTest#M">M</a></li>
   <li> <a href="frontend/viewallLabTest#N">N</a></li>
   <li> <a href="frontend/viewallLabTest#O">O</a></li>
   <li> <a href="frontend/viewallLabTest#P">P</a></li>
   <li> <a href="frontend/viewallLabTest#Q">Q</a></li>
   <li> <a href="frontend/viewallLabTest#R">R</a></li>
   <li> <a href="frontend/viewallLabTest#S">S</a></li>
   <li> <a href="frontend/viewallLabTest#T">T</a></li>
   <li> <a href="frontend/viewallLabTest#U">U</a></li>
   <li> <a href="frontend/viewallLabTest#V">V</a></li>
   <li> <a href="frontend/viewallLabTest#W"> W</a></li>
   <li> <a href="frontend/viewallLabTest#Y">X</a></li>
   <li> <a href="frontend/viewallLabTest#Y">Y</a></li>
   <li> <a href="frontend/viewallLabTest#Z">Z</a></li>
 </ul>                
</div>

<div class=" col-12 prescriptions-products">
<h5 id="A"> <a name="#">A</a></h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('a');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?> </a></li>  
    <?php } ?> 
</ul>


<h5 id="B"><a name="#"></a>B</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('b');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?> 
</ul>

<h5 id="C"><a name="#"></a>C</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('c');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="D"><a name="#"></a>D</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('d');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="E"><a name="#"></a>E</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('e');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>


<h5 id="F"><a name="#"></a>F</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('f');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="G"><a name="#"></a>G</h5>
<ul class="app-list">
   <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('g');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="H"><a name="#"></a>H</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('h');
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="I"><a name="#"></a>I</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('i');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="J"><a name="#"></a>J</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('j');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="K"><a name="#"></a>K</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('k');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="L"><a name="#"></a>L</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('l');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="M"><a name="#"></a>M</h5>
<ul class="app-list">    
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('m');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="N"><a name="#"></a>N</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('n');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="O"><a name="#"></a>O</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('o');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="P"><a name="#"></a>P</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('p');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="Q"><a name="#"></a>Q</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('q');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="R"><a name="#"></a>R</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('r');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="S"><a name="#"></a>S</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('s');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="T"><a name="#"></a>T</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('t');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="U"><a name="#"></a>U</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('u');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="V"><a name="#"></a>V</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('v');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="W"><a name="#"></a>W</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('w');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="X"><a name="#"></a>X</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('x');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="Y"><a name="#"></a>Y</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('y');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

<h5 id="Z"><a name="#"></a>Z</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalllabTestsdatabyletter('z');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            
     ?>
    <li> <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo ucwords($value->name) ?>      </a></li>  
    <?php } ?>
</ul>

</div>
</div>
<br>
<br>