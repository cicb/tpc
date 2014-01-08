SELECT
    PuntosventaNom,
    SUM(t1.VentasCosBol+t1.VentasCarSer),
    COUNT(*),
    MAX(VentasFecHor)
FROM ventas AS t
INNER JOIN ventaslevel1 as t1 ON t.VentasId=t1.VentasId 
INNER JOIN puntosventa  as t2 ON t2.PuntosventaId=t.PuntosVentaId
WHERE t.VentasFecHor BETWEEN '2013-01-01' AND '2013-02-01'
    AND VentasSec like 'FARMATODO'
GROUP BY PuntosventaNom
;
