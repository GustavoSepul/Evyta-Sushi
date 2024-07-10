<div class="row m-0">
    <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12" style="top:0px;">
        <nav class="sidebar  botones" style="top:0x;">
            <span>Búsqueda</span>
            
            <div>
                <input wire:model="buscador" class="form-control" type="text" name="" placeholder="Sushi de salmón">
            </div>
            <label for="">Local</label>
            <div>
                <select wire:model.lazy="id_local" class="form-control" name="localSelect" id="localSelect">
                    @foreach ($locales as $local)
                        <option value="{{$local->id}}">{{$local->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <label for="">Precio</label>
            <div class="block__content">
                <div class="block__price pr-3 pl-3">
                    <div id="slide-price" wire:ignore></div>
                </div>
            </div>
            <br>
            <div class="block__input">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" wire:model.lazy="min_price" id="input-with-keypress-0">
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" wire:model.lazy="max_price" id="input-with-keypress-1">
                </div>
            </div>
            <br>
            <label for="">Categoria</label>
            <div>
                <select wire:model.lazy="id_categoria" class="form-control my-2" name="categoriaSelect" id="categoriaSelect">
                    @foreach ($categorias as $categoria)
                        <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </nav>
    </div>
    <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 py-2">
        <div class="row m-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover animate__animated animate__fadeInUp">
                        <thead class="thead-dark">
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                @auth
                                <th>Opciones</th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                            <tr class="animate__animated animate__fadeInUp">
                                <td>
                                    <img class="card-img-top img-fluid" style="width:200px;" src="{{asset('storage/'.$producto->imagen)}}" alt="Card image cap">
                                </td>
                                <td><h5>{{$producto->nombre}}</h5></td>
                                <td><p>{{$producto->descripcion}}</p></td>
                                <td><h5>${{$producto->precio}}</h5></td>
                                @auth
                                <td>
                                    <a class="text-body carrito"  data-toggle="modal" data-target="#verdetalles" onclick="verdetalles({{$producto->id}})"><i class="fa fa-eye text-primary me-2"></i>Ver detalles</a>
                                    <br>
                                    <a class="text-body carrito"  onclick="agregaralcarrito({{$producto->precio.$producto->id}}, {{$producto->id}})"><i class="fa fa-shopping-bag text-primary me-2"></i>Agregar al carrito</a>
                                    <br>
                                    <input required min="1" type="number" name="" id="{{$producto->precio.$producto->id}}" value="1" style="width:40px">
                                </td>
                                @endauth
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.css" integrity="sha512-MKxcSu/LDtbIYHBNAWUQwfB3iVoG9xeMCm32QV5hZ/9lFaQZJVaXfz9aFa0IZExWzCpm7OWvp9zq9gVip/nLMg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.js" integrity="sha512-1mDhG//LAjM3pLXCJyaA+4c+h5qmMoTc7IuJyuNNPaakrWT9rVTxICK4tIizf7YwJsXgDC2JP74PGCc7qxLAHw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script defer src="https://unpkg.com/alpinejs@3.10.3/dist/cdn.min.js"></script>
<style>
    nav svg{
        height: 20px;
    }
</style>
<script>
    document.addEventListener('livewire:load', function(){
        var rangeSlider = document.getElementById('slide-price');
        var start_min = Math.round(@this.start_min);
        var start_max = Math.round(@this.start_max);
        if(rangeSlider){
            var input0 = document.getElementById('input-with-keypress-0');
            var input1 = document.getElementById('input-with-keypress-1');
            var inputs = [input0, input1];
            noUiSlider.create(rangeSlider, {
                start: [start_min, start_max],
                connect: true,
                step: 1,
                range:{
                    min: [start_min],
                    max: [start_max]
                }
            });

            rangeSlider.noUiSlider.on('update', function(values, handle){
                @this.set('min_price', values[0]);
                @this.set('max_price', values[1]);
                inputs[handle].value = values[handle];
                function setSliderHandle(i, value){
                    var r = [NULL, NULL];
                    r[i] = value;
                    rangeSlider.noUiSlider.set(r);
                }
                inputs.forEach(function(input, handle){
                    input.addEventListener('change', function(){
                        setSliderHandle(handle, this.value);
                    });

                    input.addEventListener('keydown', function(e){
                        var values = rangeSlider.noUiSlider.get();
                        var value = Number(values[handle]);
                        var steps = rangeSlider.noUiSlider.steps();
                        var step = steps[handle];
                        var position;
                        switch(e.which){
                            case 13:
                                setSliderHandle(handle, this.value);
                                break;
                            case 38:
                                position = step[1];
                                if(position === false){
                                    position = 1;
                                }
                                if(position !== null){
                                    setSliderHandle(handle, value+position);
                                }
                                break;
                            case 40:
                                position = step[0];
                                if(position === false){
                                    position = 1;
                                }
                                if(position !== null){
                                    setSliderHandle(handle, value-position)
                                }
                                break;
                        }
                    });
                });
            });
        }
    });
</script>