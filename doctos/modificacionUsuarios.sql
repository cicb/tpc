ALTER TABLE `taquilla_ver3`.`usuarios` 
CHANGE COLUMN `UsuariosId` `UsuariosId` BIGINT(20) NOT NULL AUTO_INCREMENT ,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`UsuariosId`);
