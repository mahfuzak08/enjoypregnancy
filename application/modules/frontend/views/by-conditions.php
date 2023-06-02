<!-- Page Content -->
<div class="content">
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="page-breadcrumb product-breadcrumb">
        <ol class="breadcrumb">
            <li class=""><a href="<?php echo base_url() ?>">Home</a></li>
            <li> / </li>
            <li class=""><a href="<?php echo base_url() ?>frontend/pharmacy">Pharmacy</a></li>
            <li> / </li>                
            <li class="" aria-current="page">All Medicines</li>
        </ol>
    </nav>
    <br>

    <div class="row text-center">
        <div class="col-12">
            <h2> <b> ALL Medicines </b></h2>
            <p>Select one of the categories below.</p>
        </div>
    </div>
</div>

<div class="col-12 text-center">    
  <ul class="appendix-list">
   <li> <a href="frontend/by_conditions#A">A</a></li>
   <li> <a href="frontend/by_conditions#B">B</a></li>
   <li> <a href="frontend/by_conditions#C">C</a></li>
   <li> <a href="frontend/by_conditions#D">D</a></li>
   <li> <a href="frontend/by_conditions#E">E</a></li>
   <li> <a href="frontend/by_conditions#F">F</a></li>
   <li> <a href="frontend/by_conditions#G">G</a></li>
   <li> <a href="frontend/by_conditions#H">H</a></li>
   <li> <a href="frontend/by_conditions#I">I</a></li>
   <li> <a href="frontend/by_conditions#J">J</a></li>
   <li> <a href="frontend/by_conditions#K">K</a></li>
   <li> <a href="frontend/by_conditions#L">L</a></li>
   <li> <a href="frontend/by_conditions#M">M</a></li>
   <li> <a href="frontend/by_conditions#N">N</a></li>
   <li> <a href="frontend/by_conditions#O">O</a></li>
   <li> <a href="frontend/by_conditions#P">P</a></li>
   <li> <a href="frontend/by_conditions#Q">Q</a></li>
   <li> <a href="frontend/by_conditions#R">R</a></li>
   <li> <a href="frontend/by_conditions#S">S</a></li>
   <li> <a href="frontend/by_conditions#T">T</a></li>
   <li> <a href="frontend/by_conditions#U">U</a></li>
   <li> <a href="frontend/by_conditions#V">V</a></li>
   <li> <a href="frontend/by_conditions#W"> W</a></li>
   <li> <a href="frontend/by_conditions#Y">X</a></li>
   <li> <a href="frontend/by_conditions#Y">Y</a></li>
   <li> <a href="frontend/by_conditions#Z">Z</a></li>
 </ul>                
</div>

<div class=" col-12 prescriptions-products">
<h5 id="A"> <a name="#">A</a></h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('a');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?> 
</ul>


<h5 id="B"><a name="#"></a>B</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('b');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?> 
</ul>

<h5 id="C"><a name="#"></a>C</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('c');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="D"><a name="#"></a>D</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('d');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="E"><a name="#"></a>E</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('e');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>


<h5 id="F"><a name="#"></a>F</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('f');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="G"><a name="#"></a>G</h5>
<ul class="app-list">
   <?php 
        $conditions = $this->frontend_model->getalldatabyletter('g');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="H"><a name="#"></a>H</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('h');
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="I"><a name="#"></a>I</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('i');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="J"><a name="#"></a>J</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('j');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="K"><a name="#"></a>K</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('k');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="L"><a name="#"></a>L</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('l');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="M"><a name="#"></a>M</h5>
<ul class="app-list">    
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('m');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="N"><a name="#"></a>N</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('n');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="O"><a name="#"></a>O</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('o');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="P"><a name="#"></a>P</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('p');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="Q"><a name="#"></a>Q</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('q');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="R"><a name="#"></a>R</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('r');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="S"><a name="#"></a>S</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('s');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="T"><a name="#"></a>T</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('t');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="U"><a name="#"></a>U</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('u');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="V"><a name="#"></a>V</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('v');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="W"><a name="#"></a>W</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('w');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="X"><a name="#"></a>X</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('x');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="Y"><a name="#"></a>Y</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('y');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="Z"><a name="#"></a>Z</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getalldatabyletter('z');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbycondition($value->category_name);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->category_name ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

</div>
</div>
<br>
<br>