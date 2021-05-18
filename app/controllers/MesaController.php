<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $cliente_id = $parametros['cliente_id'];

        
        $mesa = new Mesa();
        $mesa->cliente_id = $cliente_id;
        $mesa->pedidos_id = Mesa::obtenerId()+1;
        $mesa->estado = "Esperando Pedido";
        $mesa->crearMesa();

        $payload = json_encode(array("mensaje" =>  "Mesa creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TomarPedido($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];
        $producto_id = $parametros['producto_id'];
        $cantidad = $parametros['cantidad'];

        $mesa = Mesa::obtenerMesa($id,);
        $mesa->cargarPedido($producto_id, $cantidad);

        $payload = json_encode(array("mensaje" =>  "CargaPedido Exitosa"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

   

    public function TraerUno($request, $response, $args)
    {
        
        $mesa = $args['id'];
        $nombre = Mesa::obtenerMesa($mesa);
        $payload = json_encode($nombre);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesa::obtenerTodos();
        $payload = json_encode(array("listaMesa" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
       Mesa::modificarUsuario($nombre);

        $payload = json_encode(array("mensaje" =>  "Mesa modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuarioId = $parametros['usuarioId'];
       Mesa::borrarUsuario($usuarioId);

        $payload = json_encode(array("mensaje" =>  "Mesa borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
