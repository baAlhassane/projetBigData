DROP TABLE IF EXISTS Proteine,Gene,Espece,Commentaire,Liens,Keyword,Sequence,Fiche;

CREATE TABLE Proteine(
nomAlternatif varchar(30),
nomCourt varchar(30),
nomComplet varchar(30) PRIMARY KEY,
ecNumber varchar(30) ,
nomProteineGene varchar(30) NOT NULL ,/* attribut lier a la relation Protein * ------ 1 Gene . C'est un id de Gene en realite . c'est le nom primaire de gene*/



);

CREATE TABLE Gene(
nomPrimaire varchar(30) PRIMARY KEY,
synonyme varchar(30),
locusOrdonne varchar(30),
orf varchar(30),
nomGeneEspece varchar(30) NOT NULL,/* attribut lier a la relation Gene * ------ 1  Espece . C'est un id de Espece en realite. C'est le nom espece*/


);

CREATE TABLE Espece (
espece varchar(30);
idTaxonomieNcbi Integer PRIMARY KEY;/* https://www.ncbi.nlm.nih.gov/Taxonomy/TaxIdentifier/tax_identifier.cgi quel est la difference avec idTaxonomieUniprot  */



);


CREATE TABLE commentaire(
fonctionBio varchar(30)PRIMARY KEY,/*Ici on considere que le couple  fonctionBio et desease constitue une cle primaire*/
desease varchar(30)PRIMARY KEY,
 nomCommentaireProteine varchar(30) NOT NULL;/* attribut lier a la relation Commenatire * ------ 1  Espece . C'est un id de Espece en realite*/
 nomCommentaireGene varchar(30)NOT NULL, /* attribut lier a la relation Commenatire * ------ 1  Gene. C'est un id de Gene en realite*/
) ;


/* https://www.uniprot.org/help/taxonomy  The taxonomy database that is maintained by the UniProt group is based on the NCBI taxonomy database. You can query the UniProt taxonomy by taxon names or NCBI taxonomy identifiers. Searches by names are case-insensitive and you may use asterisks as wildcards anywhere in the query. When you search for taxon names, the results that match a UniProt organism denomination are ranked higher than those which match other organism names.
*/

CREATE TABLE Liens(
nomBase varchar(30) PRIMARY KEY,/*Ici on considere que le couple nomBase et idTaxonomieUniprot constitue une cle primaire*/;
idTaxonomieUniprot Integer ,/* https://www.uniprot.org/taxonomy/2759 pourdquoi pas idTaxonomieNCBI*/



);


CREATE TABLE Keyword(
keyword varchar(30), 

);

CREATE TABLE Fiche(
numAccession varchar (30) PRIMARY KEY ;
typeBase varchar(30), /*SwissProt or TrEMBL */ 
keyword varchar(30) NOT NULL, /* attribut lier a la relation Fiche * ------ 1  Keyword. C'est un id de Gene en realite*/ 
dateCreationFiche varchar(30),
dateditiofFiche varchar(30),
version

);

CREATE TABLE Sequence(
sequence varchar(10000) PRIMARY KEY, 
masse float, 
nomPrimaire varchar(30) NOT NULL /* attribut lier a la relation Sequence * ------ 1  Gene. C'est un id de Gene en realite. */ 
);


/* la table d'association Liens * ----- * Espece */
CREATE TABLE EspeceLiens( 
espece  varchar(30),
nomBase  varchar(30),
idTaxonomieUniprot Integer NOT NULL,
id TaxonomieNcbi Integer NOT NULL,


);

/*  


 REMARQUE : 
 J'ai eu du mal à choisir le cle primaire dans cerataines tables telles que Gene et Proteine. 
 

 Au debut j'avais creée une assocation entre les proteinnes et les sequences. Ensuite dans mes lectures j'ai vu quelques ou est dit part qu'il est plus facile de sequencer un gene qu'un proteine et on ne parle pas de sequence pour une proteine mais plutot codon.

Raison pour laquelle j'ai pas fait une association entre Sequence et Proteine meme si c'est faisable.

 


 */



