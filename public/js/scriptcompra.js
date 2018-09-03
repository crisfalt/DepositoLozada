



function validarmayor()
    { 


       var totalfactura = document.getElementById("total").value; 
       var idfac = document.getElementById("idfac").value; 
      var abono = document.getElementById("numero2").value; 

      
             if(document.getElementById("numero2").value == ""||document.getElementById("numero2").value == null)
              { 
                alert("campo");
                var x=document.getElementById("numero2").value=0;

              }

              else
              {
                 var abono = document.getElementById("numero2").value;                
                 if(parseFloat(abono)>parseFloat(totalfactura))
                {
                    
                    alert("usted no puede ingresar una valor mayor al saldo de la factura");
                     document.getElementById("numero2").value = "";
                     document.getElementById("numero2").focus();
                }
                else
                {
               
                  // var entregar='<a  href="/venta/recibo/"+ idfac +"/4/"  class="btn btn-info btn-round" > registrar y abonar</a>';
                  // var pentregar='<a  href="{{ action('+'VentaController@recibo'+',['+'id'+' =>'+idfac+','+'estado'+'=>0,'+'abono'+'=>'+abono+']) }}"  class="btn btn-info btn-round" > por entregar y abonar</a>';
                  var resta=parseFloat(totalfactura)-parseFloat(abono);

                  document.getElementById("deuda").value=resta;
                  document.getElementById('porrecibir').href = "/compra/recibo/"+ idfac +"/4/"+abono;
                
                  document.getElementById('recido').href = "/compra/recibo/"+ idfac +"/0/"+abono;
                }

              }

                  
             
    
       
    }



function solo_numeros(e){
            var key = window.Event ? e.which : e.keyCode 
            return ((key >= 48 && key <= 57) || (key==8)) 
        }




    n =  new Date();
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();
    document.getElementById("date").innerHTML = m + "/" + d + "/" + y;
    function validacionAgregar()
{
var combo = document.getElementById('combobox').value;

if(combo==0)
{
alert("debe seleccionar un producto");
return false;
}


}

    
      $("#proveedors").focus();

        $.ajaxSetup({
            beforeSend: function(xhr, type) {
                if (!type.crossDomain) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            },
        });
        function AbrirModalCanasta()
        {
         
          
          var cantidadcanasta = document.getElementById('cantidadcanasta').value;
          if(cantidadcanasta==0)
          {
              document.getElementById('cantidadcanasta').value=0;
              $("#cantidadcanasta").focus();
              alert("ingresa las cantidad de canasta")
              return(0);
        
          }
        
          cantidadEnvase=document.getElementById('cantidaenvase').value;
          cantidadPlastico=document.getElementById('cantidadPlastico').value;
         
          var ruta=window.location.host;
        
          var tipopaca = document.getElementById('tipopaca').value;
          var ruta2 = '/compra/ConsultarCanasta/'+ tipopaca;
        
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            type: "GET",
            url: ruta2,
              
            dataType: "json",
            success: function (items) {
              // console.log(items.items[0]);
              var datos = items.items;
              var CantidadCanastaActual=parseInt(items.cantidadCanasta) ;
            
              // var datos2= items.items[1];
            // for( var i = 0 ; i < nombres.length ; i++ ) {
            //   $("#tipocontenido").append($("<option />").val(ids[i]).text(nombres[i]));
            // }
            
            var contador=0;
            var cantidad=0;
           
              var contenido = '<form action="" class="formName" >';
              
              for( var j = 0 ; j < cantidadcanasta ; j++ ) {
                
                contenido += '<hr>';
                contenido += '<p>Contenido de la Canasta #'+ (j+1) +'</p>';
                contenido += '<div class="row">';
                contenido += '<br>';
                for( var i = 0 ; i < datos.length ; i++ ) {
                  contenido += '<input id="idProducto'+contador+'" name="fk_id_producto" type="hidden" value="'+datos[i].codigo+'" >';
                  contenido += '<div class="col-md-3"><label>'+datos[i].nombre+'</label></div>';
                  contenido += '<div class="col-md-3"><input type="number" id="cantidadCompra'+contador+'" value="0"  min="0" placeholder="Tu Cantidad" class="form-control" required /></div>';
                  contador=contador+1;
                }
             
                contenido += '</div>';
              }
              
              contenido += '</div>'+'</form>';
        
           
              console.log(contenido);
          
          var notificacion="";
            $.confirm({
              title: 'Selecione el Contenido de la canasta',
              columnClass : 'col-md-10',
              content: contenido,
            buttons: {
              formSubmit: {
                  text: 'Agregar',
                  btnClass: 'btn-blue',
                  action: function () 
                  {
                    var arrayId = [];
                    var arrayCantidad = [];
                    var TotalCantidad=0;
                    var TotalCantidadFaltante=0;
                    var tmp = 0;
                    var sumaProductos = 0;
                    var notificacion="";
                    for( var j = 0 ; j < cantidadcanasta ; j++ ) {
                      for( var i = 0 ; i < datos.length ; i++ ) {
                          var ProductoRecorrer= document.getElementById('idProducto'+tmp+'').value;
                          var cantidadRecorrer= $('#cantidadCompra'+tmp).val();
                          arrayId[tmp] = ProductoRecorrer;
                          arrayCantidad[tmp] = cantidadRecorrer;
                          if(cantidadRecorrer=="")
                          {
                              document.getElementById('cantidadCompra'+tmp+'').value=0;
                              $("#cantidadCompra"+tmp).focus();
                              $.alert("campo cantidad no tiene que estar vacio");
                              return(0);
                          }
                          tmp++;
                          sumaProductos += parseInt(cantidadRecorrer);
                          TotalCantidad=parseInt(cantidadRecorrer) + parseInt(TotalCantidad);
                      }
                      if( sumaProductos > CantidadCanastaActual ) {
                        notificacion+=('\nla cantidad de productos en la canasta ' +(j+1) + ' se paso del limite ' + CantidadCanastaActual+' ');
                          
                      }
                      if( sumaProductos < CantidadCanastaActual ) {
                        notificacion+=('\nla cantidad de productos en la canasta ' +(j+1) + ' debe ser igual a ' + CantidadCanastaActual);
                         
                      }
                     
                      sumaProductos = 0;
                    }
                    if(notificacion !="")
                    {
                      $.alert(notificacion);
                      return(0);
                    }
                      var ruta2 = '/compra/AgregarCanasta/';
        
                      $.ajax({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                        type: "post",
                        url: ruta2,
                          data : {'ids' : arrayId,'cantidad' : arrayCantidad,'cantidadCanasta' : cantidadcanasta,'cantidadEnvase':cantidadEnvase,'tipoPaca':tipopaca,'cantidadPlastico':cantidadPlastico,'datosCanasta':datos,'cantidadcanasta':cantidadcanasta},
                        dataType: "json",
                        success: function (items) {
                        alert(items.items);
                          location.reload();
                        }
                      }); 
        
                  }
              },
              cancel: function () {
                  //close
              },
          },
          onContentReady: function () {
              // bind to events
              var jc = this;
              this.$content.find('form').on('submit', function (e) {
                  // if the user submits the form by pressing enter in the field.
                  e.preventDefault();
                  jc.$$formSubmit.trigger('click'); // reference the button and click it
              });
          }
        });   
        
            
         
            
              }
          });
        
        }
        
        
        
        
        
        
        //////////
            function enviarDatos() {
        
              // var formulario = $('#AgregarCompra');
              var marca = document.getElementById('marca').value;               
              var tipocontenido = document.getElementById('tipocontenido').value              
              var tipopaca = document.getElementById('tipopaca').value;             
              var combobox=document.getElementById('combobox').value;         
              var cantidaenvase=document.getElementById('cantidaenvase').value;              
              var cantidad=document.getElementById('cantidad4').value;
             
              // var fk_precio=document.formulario.getElementById('fk_precio').value;
              
              
              var DatosCompras=[marca,tipocontenido,tipopaca,combobox,cantidaenvase,cantidad];
              alert(DatosCompras);
              
              var ruta=window.location.host;
              var ruta2 = '/AgregarCompra/'+DatosCompras;
          
             
              $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: ruta2,
                  dataType : 'json',
                  type: 'post',
                  success:function(response) {
                        alert(response.msg);
                       console.log(response);
                  }
             });
            //  alert('me cago');
            
            
          }
            
            
        
              $("#combobox2").focus();
        
                $.ajaxSetup({
                    beforeSend: function(xhr, type) {
                        if (!type.crossDomain) {
                            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                        }
                    },
                });
                function agregarCantidad(valorId,Cantidad) 
                {
                  // alert("hola");
                    var cantidad = Cantidad;
                    var idOut=valorId;
                    var ruta='http://'+window.location.host;
                    var ruta2 = ruta+ '/compra/agregarCantidad/'+cantidad+'/'+idOut;
                    var data = idOut;
                   
                    $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: ruta2,
                        dataType : 'json',
                        type: 'POST',
                        data: {},
                        contentType: false,
                        processData: false,
                        success:function(response) {

                           location.reload(true);
                             console.log(response);
                        }
                   });
                    location.reload(true);
                  
                }
                  function agregarCantidadEditar(valorId,Cantidad) 
                {
                    var cantidad = Cantidad;
                    var idOut=valorId;
                    var ruta='http://'+window.location.host;
                    var ruta2 = ruta+ '/compra/agregrarCantidadEditar/'+cantidad+'/'+idOut;
                    var data = idOut;
                    
                    $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: ruta2,
                        dataType : 'json',
                        type: 'POST',
                        data: {},
                        contentType: false,
                        processData: false,
                        success:function(response) {
                             console.log(response);
                             location.reload(true);
                        }
                   });
                   
                    location.reload(true);
                }
        ////evento change para listar producto
        
        $("#tipopaca").change(function () {
          // alert($(this).val());
            var ruta='http://'+window.location.host;
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
              type: "GET",
              url: ruta+"/compra/MostrarProducto/"+ $(this).val(),
                
              dataType: "json",
              success: function (items,responseTexr) {
            
        // alert(items.retornable);
        
             
             if(1==items.retornable)
             {
              
              document.getElementById('cantidaenvaseOcultar').style.display = 'block';
              document.getElementById('cantidadPlasticoOcultar').style.display = 'block';
             }
             else{
              document.getElementById('cantidaenvaseOcultar').style.display = 'none';
              document.getElementById('cantidadPlasticoOcultar').style.display ='none'
             }
        
        
             if(0==items.id)
             {
              document.getElementById('OcultarBotonModal').style.display = 'none';
             
              $("#combobox").empty(); $("#combobox").append($("<option />").val("0").text("SELECCIONE El PRODUCTO"));
              document.getElementById('cantidad4Ocultar').style.display = 'block';
              document.getElementById('cantidadcanastaOcultar').style.display = 'none';
              document.getElementById('OcltarBotonSubmit').style.display = 'block';
              document.getElementById('comboboxOCultar').style.display = 'block';
            
             }
             if(0!=items.id)
             {
              document.getElementById('OcultarBotonModal').style.display = 'block';
              document.getElementById('OcultarBotonModal').style.display = 'block';
              $("#combobox").empty(); $("#combobox").append($("<option />").val("0").text("SELECCIONE El PRODUCTO"));
              document.getElementById('comboboxOCultar').style.display = 'none';
              document.getElementById('cantidadcanastaOcultar').style.display = 'block';
              document.getElementById('cantidad4Ocultar').style.display = 'none';
              document.getElementById('OcltarBotonSubmit').style.display = 'none';
           
                
             }
            
            
             document.getElementById('cantidaenvase').value="0";
             document.getElementById('cantidaenvase').value="0";
             
             document.getElementById('cantidad4').value="0";
             document.getElementById('cantidad4').value="0";
             
           
             
                // document.getElementById('comboboxOCultar').style.display = 'block';
                var datos = items.items;
                $('#combobox').prop('disabled', false);
                
                $("#combobox").empty(); $("#combobox").append($("<option />").val("0").text("SELECCIONE El PRODUCTO"));
                var nombres = datos[ 0 ];
                var ids = datos[1];
                for( var i = 0 ; i < nombres.length ; i++ ) {
                  $("#combobox").append($("<option />").val(ids[i]).text(nombres[i]));
                }
        
              
              }
              });
        
          });
        
        
        //listar contenido
                $("#marca").change(function () {
                  
                  var ruta='http://'+window.location.host;
                  $('#tipopaca').prop('disabled', true);
                  $.ajax({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                    type: "GET",
                    url: ruta+"/compra/MostrarTipoContenido/"+ $(this).val(),
                      
                    dataType: "json",
                    success: function (items) {
                      // console.log(items.items[0]);
                      var datos = items.items[0];
                      var datos2= items.items[1];
                    
                      document.getElementById('cantidadcanastaOcultar').style.display = 'none';
                      document.getElementById('cantidad4Ocultar').style.display = 'block';
                      document.getElementById('comboboxOCultar').style.display = 'block';
                      document.getElementById('OcultarBotonModal').style.display = 'none';
                      document.getElementById('OcltarBotonSubmit').style.display = 'block';
                   
                    document.getElementById('tipocontenido').style.display = 'block';
                    
                    // alert(datos );
                    $('#tipocontenido').prop('disabled', false);
                    document.getElementById('cantidaenvase').value="0";
                    document.getElementById('cantidadPlastico').value="0";
                    document.getElementById('cantidad4').value="0";
                  
                    document.getElementById('cantidadcanasta').value="0";
                    
                    $("#tipocontenido").empty(); $("#tipocontenido").append($("<option />").val("0").text("SELECCIONE El TIPO CONTENIDO").addClass("form-control"));
                    $("#combobox").empty(); $("#combobox").append($("<option />").val("0").text("SELECCIONE El PRODUCTO"));
                    // var nombres = datos[ 0 ];
                    // var ids = datos[1];
                    // var nombres1 = datos2[ 0 ];
                    // var ids1 = datos2[1];
                    // for( var i = 0 ; i < nombres.length ; i++ ) {
                    //   $("#tipocontenido").append($("<option />").val(ids[i]).text(nombres[i]));
                    // }
                    datos.forEach( function( valor , index ) { 
                      // console.log(valor);
                      $("#tipocontenido").append($("<option />").val(valor.tipo_contenido.id).text(valor.tipo_contenido.nombre).addClass("form-control"));
        
                    });
        
                    datos2.forEach( function( valor , index ) { 
                      // console.log(valor);
                      $("#combobox").append($("<option />").val(valor.codigo).text(valor.nombre));
        
                    });
                    //  for( var i = 0 ; i < datos.length ; i++ ) {
                    //   $("#tipocontenido").append($("<option />").val(ids[i]).text(nombres[i]));
                    // }
                    
                 
                    
                      }
                  });
        
                });
        
        //////listar Tipo Pacas
                $("#tipocontenido").change(function () {
                // alert($(this).val());
                  var ruta='http://'+window.location.host;
                  $.ajax({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                    type: "Get",
                    url: ruta+"/compra/MostrarTipoPaca/"+ $(this).val(),
                      
                    dataType: "json",
                    success: function (items) {
                      document.getElementById('OcltarBotonSubmit').style.display = 'block';
                   
                      document.getElementById('tipopaca').style.display = 'block';
                      // var datos = items.items;
                      var datosFiltro=items.FiltroProducto;
                      var datosListarTipoContenido=items.items;
                      $('#tipopaca').prop('disabled', false);
                      $("#combobox").empty(); $("#combobox").append($("<option />").val("0").text("SELECCIONE El PRODUCTO"));
                      $("#tipopaca").empty(); $("#tipopaca").append($("<option />").val("0").text("Compra individual").addClass("form-control"));
                      document.getElementById('cantidaenvase').value="0";
                      document.getElementById('cantidad4').value="0";
                      document.getElementById('OcultarBotonModal').style.display = 'none';
                    
                      document.getElementById('cantidadcanasta').value="0";
                     
                      document.getElementById('cantidaenvaseOcultar').style.display = 'none';
                      document.getElementById('cantidadPlasticoOcultar').style.display ='none';
                      // document.getElementById('cantidad4Ocultar').style.display = 'none';
                    
                      document.getElementById('cantidadcanastaOcultar').style.display = 'none';
                      cantidadcanastaOcultar
                      // var nombres = datosListarTipoContenido[ 0 ];
                      // var ids = datosListarTipoContenido[1];
                      // for( var i = 0 ; i < nombres.length ; i++ ) {
                      //   $("#tipopaca").append($("<option />").val(ids[i]).text(nombres[i]));
                      // }
                      datosListarTipoContenido.forEach( function( valor , index ) { 
                        // console.log(valor);
                        $("#tipopaca").append($("<option />").val(valor.tipo_paca.id).text(valor.tipo_paca.nombre).addClass("form-control"));
          
                      });
        
                      datosFiltro.forEach( function( valor , index ) { 
                        // console.log(valor);
                        $("#combobox").append($("<option />").val(valor.codigo).text(valor.nombre));
          
                      });
                    }
                    });
        
                });
        
        
                // para mostrar el precio
                function MostrarCanastaIndividual( nombre ) 
                {
                  document.getElementById('OcltarBotonSubmit').style.display = 'block';
                  document.getElementById('OcultarBotonModal').style.display = 'none';
                 
                    $('#fk_precio').prop('disabled', false);
                    
                    // creamos un variable que hace referencia al select
                    var select=document.getElementById("combobox").value;
                    var separar=select.split(',');
                    // for(var i=0;i<separar.length;i++){
        
        
                    // alert(separar[i]);
                    // }
                    var ruta='http://'+window.location.host;
            
                    var IdProducto=separar[0];
                    // $('#precio_compra2').val(precioCompra);
                    $.ajax({
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                      type: "POST",
                      url: ruta+"/compra/MostrarCanastaIndividual/"+IdProducto,
                        
                      dataType: "json",
                      success: function (items,responseTexr) {
                     
                
                        if(items.paca==1)
                      {
                        document.getElementById('cantidaenvaseOcultar').style.display = 'block';
                        document.getElementById('cantidadPlasticoOcultar').style.display ='block';
                     }
                       else
                     {
                      document.getElementById('cantidaenvaseOcultar').style.display = 'none';
                      document.getElementById('cantidadPlasticoOcultar').style.display ='none';
                    }
                        // $("#fk_precio").empty(); $("#fk_precio").append($("<option />").val("0").text("SELECCIONE El PRECIO DE Compra"));
                        // $.each( items, function( key, value ) {
                        //   $.each( value , function(index,precio){
                        //     $("#fk_precio").append($("<option />").val(precio.id).text(precio.valor));
                        //   }); 
                        // });
                      
                          }
                      });
              }
                     
              
    
              $("#combobox2").focus();
        
                    
        
        
                $( function() {
                    $.widget( "custom.combobox", {
                      _create: function() {
                        this.wrapper = $( "<span>" )
                          .addClass( "custom-combobox" )
                          .insertAfter( this.element );
                 
                        this.element.hide();
                        this._createAutocomplete();
                        this._createShowAllButton();
                      },
                 
                      _createAutocomplete: function() {
                        var selected = this.element.children( ":selected" ),
                          value = selected.val() ? selected.text() : "";
                 
                        this.input = $( "<input>" )
                          .appendTo( this.wrapper )
                          .val( value )
                          .attr( "title", "" )
                          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
                          .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy( this, "_source" )
                          })
                          .tooltip({
                            classes: {
                              "ui-tooltip": "ui-state-highlight"
                            }
                          });
                 
                        this._on( this.input, {
                          autocompleteselect: function( event, ui ) {
                            ui.item.option.selected = true;
                            this._trigger( "select", event, {
                              item: ui.item.option
                            });
                          },
                 
                          autocompletechange: "_removeIfInvalid"
                        });
                      },
                 
                      _createShowAllButton: function() {
                        var input = this.input,
                          wasOpen = false
                 
                        $( "<a>" )
                          .attr( "tabIndex", -1 )
                          .attr( "title", "Show All Items" )
                          .attr( "height", "" )
                          .tooltip()
                          .appendTo( this.wrapper )
                          .button({
                            icons: {
                              primary: "ui-icon-triangle-1-s"
                            },
                            text: "false"
                          })
                          .removeClass( "ui-corner-all" )
                          .addClass( "custom-combobox-toggle ui-corner-right" )
                          .on( "mousedown", function() {
                            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
                          })
                          .on( "click", function() {
                            input.trigger( "focus" );
                 
                            // Close if already visible
                            if ( wasOpen ) {
                              return;
                            }
                 
                            // Pass empty string as value to search for, displaying all results
                            input.autocomplete( "search", "" );
                          });
                      },
                 
                      _source: function( request, response ) {
                        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                        response( this.element.children( "option" ).map(function() {
                          var text = $( this ).text();
                          if ( this.value && ( !request.term || matcher.test(text) ) )
                            return {
                              label: text,
                              value: text,
                              option: this
                            };
                        }) );
                      },
                 
                      _removeIfInvalid: function( event, ui ) {
                 
                        // Selected an item, nothing to do
                        if ( ui.item ) {
                          return;
                        }
                 
                        // Search for a match (case-insensitive)
                        var value = this.input.val(),
                          valueLowerCase = value.toLowerCase(),
                          valid = false;
                        this.element.children( "option" ).each(function() {
                          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                            this.selected = valid = true;
                            return false;
                          }
                        });
                 
                        // Found a match, nothing to do
                        if ( valid ) {
                          return;
                        }
                 
                        // Remove invalid value
                        this.input
                          .val( "" )
                          .attr( "title", value + " didn't match any item" )
                          .tooltip( "open" );
                        this.element.val( "" );
                        this._delay(function() {
                          this.input.tooltip( "close" ).attr( "title", "" );
                        }, 2500 );
                        this.input.autocomplete( "instance" ).term = "";
                      },
                 
                      _destroy: function() {
                        this.wrapper.remove();
                        this.element.show();
                      }
                    });
                    
                    $( "#combobox2" ).combobox();
                    $( "#toggle" ).on( "click", function() {
                        $( "#combobox2" ).toggle();
                    });
            });
        
        
        
                $( function() {
                    $.widget( "custom.combobox", {
                      _create: function() {
                        this.wrapper = $( "<span>" )
                          .addClass( "custom-combobox" )
                          .insertAfter( this.element );
                 
                        this.element.hide();
                        this._createAutocomplete();
                        this._createShowAllButton();
                      },
                 
                      _createAutocomplete: function() {
                        var selected = this.element.children( ":selected" ),
                          value = selected.val() ? selected.text() : "";
                 
                        this.input = $( "<input>" )
                          .appendTo( this.wrapper )
                          .val( value )
                          .attr( "title", "" )
                          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
                          .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy( this, "_source" )
                          })
                          .tooltip({
                            classes: {
                              "ui-tooltip": "ui-state-highlight"
                            }
                          });
                 
                        this._on( this.input, {
                          autocompleteselect: function( event, ui ) {
                            ui.item.option.selected = true;
                            this._trigger( "select", event, {
                              item: ui.item.option
                            });
                          },
                 
                          autocompletechange: "_removeIfInvalid"
                        });
                      },
                 
                      _createShowAllButton: function() {
                        var input = this.input,
                          wasOpen = false
                 
                        $( "<a>" )
                          .attr( "tabIndex", -1 )
                          .attr( "title", "Show All Items" )
                          .attr( "height", "" )
                          .tooltip()
                          .appendTo( this.wrapper )
                          .button({
                            icons: {
                              primary: "ui-icon-triangle-1-s"
                            },
                            text: "false"
                          })
                          .removeClass( "ui-corner-all" )
                          .addClass( "custom-combobox-toggle ui-corner-right" )
                          .on( "mousedown", function() {
                            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
                          })
                          .on( "click", function() {
                            input.trigger( "focus" );
                 
                            // Close if already visible
                            if ( wasOpen ) {
                              return;
                            }
                 
                            // Pass empty string as value to search for, displaying all results
                            input.autocomplete( "search", "" );
                          });
                      },
                 
                      _source: function( request, response ) {
                        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                        response( this.element.children( "option" ).map(function() {
                          var text = $( this ).text();
                          if ( this.value && ( !request.term || matcher.test(text) ) )
                            return {
                              label: text,
                              value: text,
                              option: this
                            };
                        }) );
                      },
                 
                      _removeIfInvalid: function( event, ui ) {
                 
                        // Selected an item, nothing to do
                        if ( ui.item ) {
                          return;
                        }
                 
                        // Search for a match (case-insensitive)
                        var value = this.input.val(),
                          valueLowerCase = value.toLowerCase(),
                          valid = false;
                        this.element.children( "option" ).each(function() {
                          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                            this.selected = valid = true;
                            return false;
                          }
                        });
                 
                        // Found a match, nothing to do
                        if ( valid ) {
                          return;
                        }
                 
                        // Remove invalid value
                        this.input
                          .val( "" )
                          .attr( "title", value + " didn't match any item" )
                          .tooltip( "open" );
                        this.element.val( "" );
                        this._delay(function() {
                          this.input.tooltip( "close" ).attr( "title", "" );
                        }, 2500 );
                        this.input.autocomplete( "instance" ).term = "";
                      },
                 
                      _destroy: function() {
                        this.wrapper.remove();
                        this.element.show();
                      }
                    });
                    
                    $( "#combobox" ).combobox();
                    $( "#toggle" ).on( "click", function() {
                        $( "#combobox" ).toggle();
                    });
            });