SELECT evento.EventoNom,
funciones.funcionesTexto,
zonas.ZonasAli as Zona,
filas.FilasAli as Fila,
lugares.LugaresLug as Asiento,
ventaslevel1.LugaresNumBol as Barras,
ventaslevel1.VentasSta as Estatus,
ventas.VentasFecHor as FechaVenta,
ventas.VentasId,
ventas.VentasNumRef,
ventas.VentasTip as TipoVenta,
ventaslevel1.VentasBolTip as TipoBoleto,
descuentos.DescuentosDes as Descuento,
puntosventa.PuntosventaId,
puntosventa.PuntosventaNom as PuntoVenta,
ventas.UsuariosId,
IF(ventas.TempLugaresTipUsr = 'usuarios',
(SELECT usuarios.UsuariosNom FROM usuarios 
WHERE UsuariosId = ventas.UsuariosId),
(SELECT clientes.ClientesNom FROM clientes 
WHERE ClientesId = ventas.UsuariosId)) AS QuienVende,
ventas.VentasNomDerTar AS NombreTarjeta,
ventas.VentasNumTar AS NumeroTarjeta,
IF(ventaslevel1.CancelUsuarioId > 0,
(SELECT usuarios.UsuariosNom FROM usuarios 
WHERE UsuariosId = ventaslevel1.CancelUsuarioId), '') AS QuienCancelo,
ventaslevel1.CancelFecHor AS FechaCancelacion,
(SELECT COUNT(reimpresiones.ReimpresionesId)
FROM reimpresiones
WHERE reimpresiones.EventoId = ventaslevel1.EventoId AND 
reimpresiones.FuncionesId = ventaslevel1.FuncionesId AND
reimpresiones.ZonasId = ventaslevel1.ZonasId AND
reimpresiones.SubzonaId = ventaslevel1.SubzonaId AND
reimpresiones.FilasId = ventaslevel1.FilasId AND
reimpresiones.LugaresId = ventaslevel1.LugaresId) as VecesImpreso,
ventaslevel1.EventoId,
ventaslevel1.FuncionesId,
ventaslevel1.ZonasId,
ventaslevel1.SubzonaId,
ventaslevel1.FilasId,
ventaslevel1.LugaresId FROM `lugares` `lugares` 
INNER JOIN filas ON (filas.EventoId = lugares.EventoId)
    AND (filas.FuncionesId = lugares.FuncionesId)
    AND (filas.ZonasId = lugares.ZonasId)
    AND (filas.SubzonaId = lugares.SubzonaId)
    AND (filas.FilasId = lugares.FilasId)
INNER JOIN zonas ON (zonas.EventoId = filas.EventoId)
    AND (zonas.FuncionesId = filas.FuncionesId)
    AND (zonas.ZonasId = filas.ZonasId)
INNER JOIN ventaslevel1 ON (lugares.EventoId = ventaslevel1.EventoId)
    AND (lugares.FuncionesId = ventaslevel1.FuncionesId)
    AND (lugares.ZonasId = ventaslevel1.ZonasId)
    AND (lugares.SubzonaId = ventaslevel1.SubzonaId)
    AND (lugares.FilasId = ventaslevel1.FilasId)
    AND (lugares.LugaresId = ventaslevel1.LugaresId)
INNER JOIN funciones ON (funciones.FuncionesId = zonas.FuncionesId)
    AND (funciones.EventoId = zonas.EventoId)
INNER JOIN ventas ON (ventaslevel1.VentasId = ventas.VentasId)
INNER JOIN descuentos ON (ventaslevel1.DescuentosId = descuentos.DescuentosId)
INNER JOIN puntosventa ON (ventas.PuntosventaId = puntosventa.PuntosventaId)
INNER JOIN evento ON (funciones.EventoId = evento.EventoId) WHERE lugares.EventoId = '493' AND 
lugares.FuncionesId = '1' AND
lugares.ZonasId = '1' AND 
FilasAli LIKE '%%' AND 
LugaresLug LIKE '%%' ORDER BY lugares.ZonasId,lugares.FilasId, lugares.LugaresLug, ventas.VentasFecHor