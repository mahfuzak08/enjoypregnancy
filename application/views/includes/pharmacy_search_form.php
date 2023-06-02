<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">            
            <div class="col-md-10 col-12 d-md-block m-auto">
                <div class="row">
                    <div class="col-md-6">
                        <form action="<?php echo base_url(); ?>frontend/products" method="get">
                        <div class="input-group">
                          <input type="text" class="form-control" name="p" id="search-products" placeholder="Search by Products" autocomplete="off">
                          <div class="input-group-append">
                            <button class="btn btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                        </form>
                        <div class="products-div">
                            <div class="card search-products">
                                <div class="card-body product-rows">                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control select2" id="search_category">
                             <option value="">Shop by category</option>
                             <?php 
                                $categories = $this->frontend_model->getallcategorieshere();
                                foreach($categories as $key => $value)
                                {
                             ?>                
                             <option value="<?php echo $value->subcategory; ?>"> <?php echo $value->subcategory; ?> </option>    
                             <?php } ?>   
                         </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control select2-brand" id="search_brands">
                            <option value="">Shop by brands</option>                                               
                            <?php 
                                $brands = $this->frontend_model->getallbrandshere();
                                foreach($brands as $key => $value)
                                {
                             ?>                
                             <option value="<?php echo $value->vendor; ?>"> <?php echo $value->vendor; ?> </option>    
                             <?php } ?> 
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->