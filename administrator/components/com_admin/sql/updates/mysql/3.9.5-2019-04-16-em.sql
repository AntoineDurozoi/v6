ALTER TABLE `jos_emundus_setup_emails` ADD `letter_attachment` INT(11) NULL DEFAULT NULL , ADD `candidate_attachment` INT(11) NULL DEFAULT NULL , ADD `category` VARCHAR(255) NULL DEFAULT NULL ; 
INSERT INTO jos_emundus_setup_emails VALUES (NULL, 'regenerate_password', 'Regénération de votre mot de passe', '', "<p>Bonjour,</p><p>Voici votre nouveau mot de passe [PASSWORD].</p><p>N'oubliez pas de le modifier lors de votre prochaine connexion.</p>",'',2 ,1 ,1 ,NULL ,NULL, NULL);