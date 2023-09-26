@extends('layouts.Frontend')
@section('title')
 products
  @endsection 
 
@section('contentss')
	


<div class="container-main">
  <section class="add-addres">
    <h3  class="text-center pb-5 add-address-main-head">Edit Address</h3>
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pb-3">
        <div class="form-group">
          <input placeholder="name" id="name" class="form-control" type="text" value="{{$add->name}}">
        </div>
      </div>
      <div class="col-xs-12  col-sm-12 col-md-6 col-lg-6 pb-3">
        <div class="form-group">
          <input  placeholder="Mobile number" id="mobile" class="form-control" type="number" value="{{$add->mobile}}">
        </div>
      </div>
      <div class="col-lg-12 pb-3">
        <div class="form-group">
         <textarea style="width: 100%;padding: 10px 10px;border: 0.3px solid grey !important;border-radius: 10px;" name="" id="address"  rows="4">{{$add->address}}</textarea>
        </div>
      </div>
      <div style="padding-left: 0;padding-right: 0;" class="col-xs-12  col-sm-12 col-md-6 col-lg-6 pb-3">
        <div class="form-group">
          <div class="col-lg-12">
           <input  placeholder="District" id="dist" class="form-control" type="text" value="{{$add->district}}">
          </div>
        </div>
      </div>
      <div style="padding-left: 0;padding-right: 0;" class="col-xs-12  col-sm-12 col-md-6 col-lg-6 pb-3">
        <div class="form-group">
          <div class="col-lg-12">
            <input  placeholder="State" id="st" class="form-control" type="text" value="{{$add->state}}">
          </div>
        </div>
      </div>
    <!--   <div style="padding-left: 0;padding-right: 0;" class="col-xs-12  col-sm-12 col-md-6 col-lg-6 pb-3">
        <div class="form-group">
          <div class="col-lg-12">
            <select name="" id="" class="form-control">
              <option selected>District</option>
              <option value="blue">Koyikode</option>
              <option value="green">Kochi</option>
              <option value="red">Kolllam</option>
              <option value="#053b6b">Malappuram</option>
            </select>
          </div>
        </div>
      </div> -->
      <!-- <div style="padding-left: 0;padding-right: 0;" class="col-xs-12  col-sm-12 col-md-6 col-lg-6">
        <div class="form-group">
          <div class="col-lg-12">
            <select name="" id="" class="form-control">
              <option selected>State</option>
              <option value="blue">Kerala</option>
              <option value="green">Goa</option>
              <option value="red">Delhi</option>
              <option value="#053b6b">Malappuram</option>
            </select>
          </div>
        </div>
      </div> -->
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6  pb-3">
        <div class="form-group">
          <input placeholder="Pincode" id="pincode" class="form-control" type="number" value="{{$add->pincode}}">
        </div>
      </div>
      <div class="col-xs-12  col-sm-12 col-md-6 col-lg-6  pb-3">
        <div class="form-group">
          <input  placeholder="Landmark" id="land" id="text" class="form-control" type="text" value="{{$add->landmark}}">
        </div>
      </div>
			<div class="col-lg-12">
				<button type="button" onclick="AddAddress()" id="ab1" class="labham-primary-bg btn btn-add-address text-white">Update</button>
				<button type="button" id="ab2" class="labham-primary-bg btn btn-add-address text-white"><i class="fa fa-spinner fa-spin"></i>  Update</button>
			</div>
    </div>
  </section>
</div>

  





<script type="text/javascript">
	
function AddAddress()
    {
    
      var name=$('input#name').val();
    
      if(name=='')
      {
        $('#name').css('border','1px solid red');
        
        return false;
      }
      else
        $('#name').css('border','1px solid #CCC');

      var mobile=$('input#mobile').val();
    
      if(mobile=='')
      {
        $('#mobile').css('border','1px solid red');
        
        return false;
      }
      else
        $('#mobile').css('border','1px solid #CCC');

     var address=$('#address').val();
    
      if(address=='')
      {
        $('#address').css('border','1px solid red');
        
        return false;
      }
      else
        $('#address').css('border','1px solid #CCC');

      var dist=$('input#dist').val();
    
      if(dist=='')
      {
        $('#dist').css('border','1px solid red');
        
        return false;
      }
      else
        $('#dist').css('border','1px solid #CCC');

      var st=$('input#st').val();
    
      if(st=='')
      {
        $('#st').css('border','1px solid red');
        
        return false;
      }
      else
       $('#st').css('border','1px solid #CCC');

      var pincode=$('input#pincode').val();
    
      if(pincode=='')
      {
        $('#pincode').css('border','1px solid red');
        
        return false;
      }
      else
        $('#pincode').css('border','1px solid #CCC');
      var land=$('input#land').val();
    
      if(land=='')
      {
        $('#land').css('border','1px solid red');
        
        return false;
      }
      else
        $('#land').css('border','1px solid #CCC');
      
     $('#ab1').hide();
      $('#ab2').show();

      data = new FormData();
      data.append('name', name);
      data.append('mobile', mobile);
      data.append('address', address);
      data.append('dist', dist);
      data.append('st', st);
      data.append('pincode', pincode);
      data.append('land', land);
      data.append('aid', '{{$add->id}}'); 

  data.append('_token', "{{ csrf_token() }}");
    
      $.ajax({
    
        type:"POST",
        url:"/address-edit",
         data: data,
        dataType:"json",
        contentType: false,
				//cache: false,
				processData: false,
       
        success:function(data)
        {
          if(data['success'])
          {
              $('#ab2').hide();
              $('#ab1').show();
             
              Toastify({
						  text: "Address updated successfully",
						  duration: 2000,
						  newWindow: true,
						  // close: true,
						  gravity: "top", // `top` or `bottom`
						  position: "right", // `left`, `center` or `right`
						  stopOnFocus: true, // Prevents dismissing of toast on hover
						  style: {
						    background: "linear-gradient(to right, green, green)",
						  },
						  callback: function () {

						  	window.location.href='/profile';
						 
						  },
						}).showToast();
          }

          if(data['err'])
          {
             
    
          }

        }
    
    
    
    
      })
    
    
    
    
    
    
    } 


</script>















@endsection