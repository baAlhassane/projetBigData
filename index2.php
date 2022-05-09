<html>

<head>
   <meta charset="utf-8" />
   <link rel="stylesheet" href="style.css" />
   
</head>
<h2>Formulaire</h2>
<hr />
<!--un nouveau formulaire -->
<form method="post" action="#">
  <fieldset>
    <legend>Recherche d'un ensemble d' entrée</legend>
    
  <p>
  <label for='pseu1'>Chaine présente dans le nom du gene</label>
  <input type="text" name="gene">
</p><p>
  <label for='pseu2'>Chaine présente dans un nom de la protéine</label>
    <input type="text" name="proteine" id="pseu2">
    </p><p>
  <label for='pseu3'>Dans un commentaire</label>
    <input type="text" name="commentaire" id="pseu3">
    </p>
<input type="submit" name"submit" value="envoyer"></fieldset>  </form>
    
    
    <?php 



       /*traitement aprés envoie du formulaire  */
    
    if ((isset($_REQUEST['gene'])) || (isset($_REQUEST['proteine'])) || (isset($_REQUEST['commentaire'])))  {
		

       /*on effectue les 3 requetes separement puis on stocke tous dans dans un tableau ensuite on affiche les accession qui sont presents 3 fois dans le tableau c'est à dire qui vérifie les 3 conditions */
		
	  $ac = '%'.$_REQUEST['gene'].'%';
	  $ac1 = '%'.$_REQUEST['proteine'].'%';
	  $ac2 = '%'.$_REQUEST['commentaire'].'%';
      $connexion= oci_connect('c##aba1_a','aba1_a','dbinfo');
      
      
       $tab=[];
      $txtReqSql1 = "select distinct en.accession from entries en, gene_names gn, entry_2_gene_name en2gn where  gn.gene_name like :acces  and eg.gene_name_id = gn.gene_name_id and en2gn.accession = en.accession";
      
     
      
      $ordreSql1 = oci_parse($connexion, $txtReq);
      oci_bind_by_name($ordreSql1, ":acces",$ac);
      oci_execute($ordreSql1);
	
     
      while (($row=oci_fetch_array($ordreSql1,OCI_BOTH)) != false){
		array_push($tab, $row[0]);
      
      }
      
    
      
      
       $txtReq1 = "select distinct e.accession from entries e, prot_name_2_prot pn, protein_names p where  p.prot_name like :acces and pn.prot_name_id = p.prot_name_id and pn.accession = e.accession";
      
      $ordre = oci_parse($connexion, $txtReq1);
      oci_bind_by_name($ordre, ":acces",$ac1);
      oci_execute($ordre);
  
      while (($row=oci_fetch_array($ordre,OCI_BOTH)) != false){
		array_push($tab, $row[0]);
      
      }
      
      
      
      
      $txtReq2 = "select distinct accession from comments where txt_c like :acces";
      
      
      $ordre = oci_parse($connexion, $txtReq2);
      oci_bind_by_name($ordre, ":acces",$ac2);
      oci_execute($ordre);



      while (($row=oci_fetch_array($ordre,OCI_BOTH)) != false){
		array_push($tab, $row[0]);
      
      }
      $tab2 = array_count_values( $tab );
      
       echo '<table>';
      
       
      foreach($tab2 as $cle=>$value){
    if ($value == 3){
    echo '<tr>';
    echo '<td>'.$cle.'</td>' ;
    echo '<td>';
    echo 'Plus d info sur cet entrée';
    echo '<form action="index.php" methode="post">' ;
	echo '<input type="submit" name="accession" value='.$cle.'>';
    echo '</form></td>' ;

    echo '</tr>';
    }

    }
echo '</table>';

oci_free_statement($ordre);
oci_close($connexion);

}


function soum($c){
echo '<form id ="fr"action = "index.php" methode="post"> <input type="text" name="accession" value=$c><input type="submit" name="sent"/>' ;
  document.getElementById("fr").submit();
}  
 
      ?>
		
		
    

    
    
    

</body>
</html>

