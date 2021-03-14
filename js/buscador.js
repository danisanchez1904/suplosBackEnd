(function (win) {
    
    /**
     * 
     * @type Array
     */
    var _results = [],
    
    /**
     * 
     * @type Array
     */
    _ciudades = [],
    
    /**
     * 
     * @type Array
     */
    _tiposInmueble = [];
    
    /**
     * 
     * @returns {undefined}
     */
    var iniciarDatos = function () {
        $.ajax({
            url: '/suplosBackEnd/app/buscador/',
            type: 'GET',
            dataType: 'json',
            data: {action: 'getAll'},
            success: callbackIniciarDatos
        });
    };
    
    /**
     * 
     * @param {Object} res
     * @returns {undefined}
     */
    var callbackIniciarDatos = function(res) {
        mostrarResultados(res);
        cargarCiudades();
        cargarTiposInmueble();
        consultarInmueblesUsuario();
    };
    
    /**
     * 
     * @param {Object} res
     * @returns {undefined}
     */
    var mostrarResultados = function (res) {
        var container = $('#resultados'),
            numRegistros = $('#num-registros'),
            html = '';        
        _results = res || [];
        numRegistros.html(_results.length);
        $.each(_results, function (i, o) {
            html += construirFila(o);
        });
        container.html(html);
    };
    
    /**
     * 
     * @returns {undefined}
     */
    var cargarCiudades = function () {
        if (_results.length) {
            _ciudades = _results.map(function (value) {
                return value.Ciudad;
            }).filter(_filtroUnicoValor);
            cargarSelectCiudades();
        }
    };
    
    /**
     * 
     * @param {String} value
     * @param {Number|String} index
     * @param {Array} self
     * @returns {Boolean}
     */
    var _filtroUnicoValor = function (value, index, self) {
        return self.indexOf(value) === index;
    };
    
    /**
     * 
     * @returns {undefined}
     */
    var cargarTiposInmueble = function () {
        if (_results.length) {
            _tiposInmueble = _results.map(function (value) {
                return value.Tipo;
            }).filter(_filtroUnicoValor);
            cargarSelectTiposInmueble();
        }
    };    
    
    /**
     * 
     * @returns {undefined}
     */
    var cargarSelectCiudades = function () {
        var select = $('#selectCiudad');
        if (_ciudades.length) {
            $.each(_ciudades, function (i, o) {
                select.append(`<option value="${o}">${o}</option>`);
            });
        }
    };
    
    /**
     * 
     * @returns {undefined}
     */
    var cargarSelectTiposInmueble = function () {
        var select = $('#selectTipo');
        if (_ciudades.length) {
            $.each(_tiposInmueble, function (i, o) {
                select.append(`<option value="${o}">${o}</option>`);
            });
        }
    };    
    
    /**
     * 
     * @param {Object} obj
     * @returns {String}
     */
    var construirFila = function (obj) {
        var template = `<tr>
            <td style="width: 200px;">
                <img src="img/home.jpg" alt="img-thumbnail" width="200" height="150">
            </td>
            <td style="text-align: left;">
                <ul>
                    <li><b>Direcci&oacuten: </b>${obj.Direccion}</li>
                    <li><b>Ciudad: </b>${obj.Ciudad}</li>
                    <li><b>Tel&eacute;fono: </b>${obj.Telefono}</li>
                    <li><b>Ciudad: </b>${obj.Codigo_Postal}</li>
                    <li><b>Tipo: </b>${obj.Tipo}</li>
                    <li><b>Precio: </b>${obj.Precio}</li>
                    <li>
                        <button type="button" onclick="guardar(${obj.Id});">Guardar</button>
                    </li>
                </ul>
            </td>                        
        </tr>`;
        return template;        
    };
    
    /**
     * 
     * @param {Object} obj
     * @returns {String}
     */
    var construirFilaInmuebleUsuario = function (obj) {
        var template = `<tr>
            <td style="width: 200px;">
                <img src="img/home.jpg" alt="img-thumbnail" width="200" height="150">
            </td>
            <td style="text-align: left;">
                <ul>
                    <li><b>Direcci&oacuten: </b>${obj.Direccion}</li>
                    <li><b>Ciudad: </b>${obj.Ciudad}</li>
                    <li><b>Tel&eacute;fono: </b>${obj.Telefono}</li>
                    <li><b>Ciudad: </b>${obj.Codigo_Postal}</li>
                    <li><b>Tipo: </b>${obj.Tipo}</li>
                    <li><b>Precio: </b>${obj.Precio}</li>
                    <li>
                        <button type="button" onclick="eliminar(${obj.Id});">Eliminar</button>
                    </li>
                </ul>
            </td>                        
        </tr>`;
        return template;        
    };    
    
    /**
     * 
     * @param {Object} event
     * @returns {undefined}
     */
    var _buscar = function (event) {
        var data = $('#formulario').serialize();
        event.preventDefault();
        $.ajax({
            url: '/suplosBackEnd/app/buscador/?' + data,
            type: 'GET',
            dataType: 'json',
            success: mostrarResultados
        });
    };
    
    /**
     * 
     * @param {Number} id
     * @returns {undefined}
     */
    var _guardar = function (id) {
        var data = {id: id, action: 'save'};
        $.ajax({
            url: '/suplosBackEnd/app/buscador/',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                var obj = res || {};
                if (obj.Id) {
                    alert('Inmueble registrado!');
                    location.reload();
                }
            }
        });        
    };
    
    /**
     * 
     * @param {Number} id
     * @returns {undefined}
     */
    var _eliminar = function (id) {
        var data = {id: id, action: 'deleteUserRow'};
        $.ajax({
            url: '/suplosBackEnd/app/buscador/',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                var obj = res || {};
                if (obj.Id) {
                    alert(`Inmueble ${obj.Id} eliminado!`);
                    location.reload();
                }
            }
        });        
    };
    
    /**
     * 
     * @returns {undefined}
     */
    var consultarInmueblesUsuario = function () {
        $.ajax({
            url: '/suplosBackEnd/app/buscador/?action=getAllUserRows',
            type: 'GET',
            dataType: 'json',
            success: mostrarInmuebles
        });        
        
    };
    
    /**
     * 
     * @param {Object} res
     * @returns {undefined}
     */
    var mostrarInmuebles = function (res) {
        var container = $('#resultados-inmuebles'),
            html = '';        
        _results = res || [];
        $.each(_results, function (i, o) {
            html += construirFilaInmuebleUsuario(o);
        });
        container.html(html);
        if (_results.length) {
            $('#tabs').tabs("option", "active", 1)
        }
    };    
    
    iniciarDatos();
    win.buscar = _buscar;
    win.guardar = _guardar;
    win.eliminar = _eliminar;
})(window);