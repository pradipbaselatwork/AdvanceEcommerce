<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach($categoryProducts as $product)
        <li class="span3">
            <div class="thumbnail">
                <a href="product_details.html">
                    @if(isset($product['main_image']))
                    <?php $product_image_path ='images/product_images/small/'.$product['main_image']; ?>
                    @else
                    <?php $product_image_path =''; ?>
                    @endif

                    @if(!empty($product['main_image']) && file_exists($product_image_path))
                    <img style="height: 170px;" width="150px;" src="{{ asset($product_image_path) }}" alt=""></a>
                    @else
                    <img style="height: 170px;" width="150px;" src="{{ asset('images/product_images/small/no-image.png') }}" alt=""></a>
                    @endif

                </a>
                <div class="caption">
                    <h5>{{ $product['product_name'] }} {{ $product['id'] }}</h5>
                    <p>
                       {{ $product['brand']['name'] }}
                    </p>
                    <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.{{ $product['product_price'] }}</a></h4>
        
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    <hr class="soft"/>
</div>