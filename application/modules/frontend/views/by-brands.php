<!-- Page Content -->
<div class="content">
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="page-breadcrumb product-breadcrumb">
        <ol class="breadcrumb">
            <li class=""><a href="<?php echo base_url() ?>">Home</a></li>
            <li> / </li>
            <li class=""><a href="<?php echo base_url() ?>frontend/pharmacy">Pharmacy</a></li>
            <li> / </li>                
            <li class="" aria-current="page">All Brands</li>
        </ol>
    </nav>
    <br>
    <div class="row text-center">
        <div class="col-12">
            <h2> <b> All Brands </b></h2>
            <p>Select one of the Brands below.</p>
        </div>
    </div>
</div>

<div class="col-12 text-center">    
  <ul class="appendix-list">
   <li> <a href="frontend/by_brands#A">A</a></li>
   <li> <a href="frontend/by_brands#B">B</a></li>
   <li> <a href="frontend/by_brands#C">C</a></li>
   <li> <a href="frontend/by_brands#D">D</a></li>
   <li> <a href="frontend/by_brands#E">E</a></li>
   <li> <a href="frontend/by_brands#F">F</a></li>
   <li> <a href="frontend/by_brands#G">G</a></li>
   <li> <a href="frontend/by_brands#H">H</a></li>
   <li> <a href="frontend/by_brands#I">I</a></li>
   <li> <a href="frontend/by_brands#J">J</a></li>
   <li> <a href="frontend/by_brands#K">K</a></li>
   <li> <a href="frontend/by_brands#L">L</a></li>
   <li> <a href="frontend/by_brands#M">M</a></li>
   <li> <a href="frontend/by_brands#N">N</a></li>
   <li> <a href="frontend/by_brands#O">O</a></li>
   <li> <a href="frontend/by_brands#P">P</a></li>
   <li> <a href="frontend/by_brands#Q">Q</a></li>
   <li> <a href="frontend/by_brands#R">R</a></li>
   <li> <a href="frontend/by_brands#S">S</a></li>
   <li> <a href="frontend/by_brands#T">T</a></li>
   <li> <a href="frontend/by_brands#U">U</a></li>
   <li> <a href="frontend/by_brands#V">V</a></li>
   <li> <a href="frontend/by_brands#W"> W</a></li>
   <li> <a href="frontend/by_brands#Y">X</a></li>
   <li> <a href="frontend/by_brands#Y">Y</a></li>
   <li> <a href="frontend/by_brands#Z">Z</a></li>
 </ul>                
</div>

<div class=" col-12 prescriptions-products">
<h5 id="A"> <a name="#">A</a></h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('a');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?> 
</ul>


<h5 id="B"><a name="#"></a>B</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('b');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?> 
</ul>

<h5 id="C"><a name="#"></a>C</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('c');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="D"><a name="#"></a>D</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('d');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="E"><a name="#"></a>E</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('e');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>


<h5 id="F"><a name="#"></a>F</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('f');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="G"><a name="#"></a>G</h5>
<ul class="app-list">
   <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('g');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="H"><a name="#"></a>H</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('h');
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="I"><a name="#"></a>I</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('i');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="J"><a name="#"></a>J</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('j');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="K"><a name="#"></a>K</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('k');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="L"><a name="#"></a>L</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('l');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="M"><a name="#"></a>M</h5>
<ul class="app-list">    
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('m');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="N"><a name="#"></a>N</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('n');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="O"><a name="#"></a>O</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('o');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="P"><a name="#"></a>P</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('p');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="Q"><a name="#"></a>Q</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('q');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="R"><a name="#"></a>R</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('r');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="S"><a name="#"></a>S</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('s');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="T"><a name="#"></a>T</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('t');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="U"><a name="#"></a>U</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('u');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="V"><a name="#"></a>V</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('v');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="W"><a name="#"></a>W</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('w');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="X"><a name="#"></a>X</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('x');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="Y"><a name="#"></a>Y</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('y');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

<h5 id="Z"><a name="#"></a>Z</h5>
<ul class="app-list">
    <?php 
        $conditions = $this->frontend_model->getallbrandsdatabyletter('z');
        // echo "<pre>";
        // print_r($conditions);
        // exit;
        foreach($conditions as $key => $value)
        {
            $countofproducts = $this->frontend_model->getproductcountbybrands($value->vendor);
     ?>
    <li> <a href="<?php echo base_url(); ?>frontend/products?p_by_brand=<?php echo urlencode($value->vendor) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $value->vendor ?> (<?php echo $countofproducts ?>)     </a></li>  
    <?php } ?>
</ul>

</div>

</div>
<br>
<br>