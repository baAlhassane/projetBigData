
<!DOCTYPE html>
<html>
  <head>
    <title>Base de donnees  Biologiques</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
  </head>
 
  <body>

 
    <!--creation du formulaire qui une fois soumis transmet les données sur la meme page -->
    
   <form id='forme' method='post' action='#'>
      <fieldset>
	<legend>Recherche d'une entrée</legend>
      <p>
	<label for='pseu2'>Numero d'accession</label>
	<input type= 'text' name='accession' id= 'pseu2' maxlenghth='12' placeholder='accession' /
      </p>
      <p>
	<input type='submit' value='envoyer' id='submit'/>
      </p>

      <!--un lien vers la page index2.php si on veut rechercher par chaine de carratere -->
      <p>
		<a href="./index2.php">Recherche avec chaine de caracteres</a>
      </p>
      
      </fieldset>
     
   </form>


   <!--traitement de la soumission du formulaire -->
   <?php

      //on verifie que l'utilisateur a saisi quelque chose
      if(isset($_REQUEST['accession'])){
      // on le recupere puis on lance la requete 
      $entree = $_REQUEST['accession'];
      $connexion= oci_connect('c##aba1_a','aba1_a','dbinfo');
      $txtReqSql= "select specie, seqLength, seqMass,CAST(seq as varchar(1000)) from proteins, entries en  where en.accession= :acces and en.accession = proteins.accession " ;
      $ordreSql = oci_parse($connexion, $txtReqSql);
      oci_bind_by_name($ordreSql, ":acces",$entree);
      oci_execute($ordreSql);
      //les info relatives à la séquence :
      echo '<h3>SEQUENCE</h3>';
      echo '<ul>';
      $colonne = '';
      while (($row=oci_fetch_array($ordreSql,OCI_BOTH)) != false){
      echo '<li>Taille : '.$row[1].'</li>';
      echo '<li> Masse : '.$row[2].'</li>' ;
      $colonne= $row[0];
      echo '<li> sequence : <p> '.$row[3].'</p></li>';
      }
     /* Le lien sur les especes dans la base NCBI*/
      $lien = "<a href=\"https://www.ncbi.nlm.nih.gov/Taxonomy/Browser/wwwtax.cgi?id=".$colonne."\"> voire la base NCBI </a>" ;
      
      echo '<li>ESPECE: '.$lien.'</li>';
      echo '</ul>';
      /* La requete sql pour pour les noms des protéines  */
      $txtReqSql = "select distinct  prn.prot_name , prn.name_kind , prn.name_type from protein_names prn, entries en, prot_name_2_prot prn2pr  where en.accession= :acces and en.accession = prn2pr.accession and prn2pr.prot_name_id = prn.prot_name_id" ;
      $ordreSql = oci_parse($connexion, $txtReqSql);
      oci_bind_by_name($ordreSql, ":acces",$entree);
      oci_execute($ordreSql);
      
      //Puis on les affiche dans un tableau
       echo '<br>'.'<h3>Protein associé</h3>';
      echo '<table>';
      echo '<tr>';
      echo '<td>Nom</td>';
	  echo '<td>Kind</td>';
      echo '<td>type</td></tr>';
      while (($row=oci_fetch_array($ordreSql,OCI_BOTH)) != false){
		echo '<tr><td>'.$row[0].'</td>';
		echo '<td>'.$row[1].'</td>';
		echo '<td>'.$row[2].'</td></tr>';
      
      }
      echo '</table>';
      
      
      /*meme chose avec les noms des genes */
      echo '<br>'.'<h3>GENE associée</h3>';
      
       $txtReqSql = "select distinct  gn.gene_name , gn.name_type from gene_names gn, entries e, entry_2_gene_name eg  where e.accession= :acces and e.accession = eg.accession and eg.gene_name_id = gn.gene_name_id" ;
      $ordreSql = oci_parse($connexion, $txtReqSql);
      oci_bind_by_name($ordreSql, ":acces",$entree);
      oci_execute($ordreSql);
      
      echo '<table>';
      echo '<tr>';
      echo '<td>Nom</td>';
	  echo '<td>Type</td>';
      
      while (($row=oci_fetch_array($ordreSql,OCI_BOTH)) != false){
		echo '<tr><td>'.$row[0].'</td>';
		echo '<td>'.$row[1].'</td></tr>';

      }
      
      echo '</table>';
      
       echo '<br>'.'<h3>Mots Clé</h3>';

     /*on recupere les mots clé qu'on va afficher dans un paragraphe */
       $txtReqSql = "select distinct kw_label from keywords k, entries e, entries_2_keywords ek   where e.accession= :acces and e.accession = ek.accession and ek.kw_id = k.kw_id" ;
      $ordre = oci_parse($connexion, $txtReqSql);
      oci_bind_by_name($ordreSql, ":acces",$entree);
      oci_execute($ordreSql);
     ;
     while (($row=oci_fetch_array($ordreSql,OCI_BOTH)) != false){
   echo '	'.$row[0].'		,';}
      
      
      
      echo '<br>'.'<h3>COMMENTAIRES</h3>';

      //on recupere les commentaires et on les affiches dans un paragraphe
    $txtReqSql = "select distinct type_c, txt_c from comments c, entries e where e.accession= :acces and e.accession = c.accession" ;
      $ordreSql = oci_parse($connexion, $txtReqSql);
      oci_bind_by_name($ordreSql, ":acces",$entree);
      oci_execute($ordreSql);
      while (($row=oci_fetch_array($ordreSql,OCI_BOTH)) != false){
   echo '<br>'.'<h5>Type de commentaire: '.$row[0].'</h5>';
   echo '<p>'.$row[1].'</p> ';
      }
      
      //les lien des termes GO
       echo '<br>'.'<h3>Informations relatives aux termes GO</h3>';
       $txtReqSql = "select distinct db_ref from dbref  where dbref.accession= :acces " ;
      $ordre = oci_parse($connexion, $txtReqSql);
      oci_bind_by_name($ordreSql, ":acces",$entree);
      oci_execute($ordreSql);
      while (($row=oci_fetch_array($ordreSql,OCI_BOTH)) != false){
      $r = $row[0];
      $url = "<a href=\"https://www.ebi.ac.uk/QuickGO/term/".$r."\"> ". $r ."</a>" ;
       echo '       '.$url;
      }
       

      function soumettre(){
document.getElementById('forme').submit();
echo '<br>';
      }
      
      oci_free_statement($ordreSql);

      oci_close($connexion);}
      ?>
 </body>
</html>
