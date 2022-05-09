

/**
*
*QUestion A
**/
SELECT prn.prot_name, com.accession,pr2pr.prot_name_id,
FROM protein_names prn ,prot_name_2_prot pr2pr, comments com 
WHERE pr2pr.accession.=com.accession
      AND pr2pr.prot_name_id=prn.prot_name_id
      AND prn.name_kind='recommendedName';

/**%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/





-- QUestion B

SELECT prn.prot_name
FROM entries_2_keywords en2kw ,prot_name_2_prot pr2pr, protein_names
WHERE en2kw.accession=prn2pr.accession
      AND prn.protein_name_id=prn2.prot_name_id
      AND en2kw.kw_id='Long QT syndrome'
      AND prn.name_kind="submittedName";

/**%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/


-- QUestion C

SELECT DISTINCT accession
FROM proteins
WHERE seqLength= SELECT MAX(p2.seqLength)
                 FROM proteins p2;


/**%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/


-- QUestion D
SELECT en2gn.accession ,count(g1.gene_name)
FROM entry_2_gene_name en2gn1, entry_2_gene_name en2gn2, gene_names g1
WHERE en2gn1.accession=en2gn2.acession
      AND en2gn1.gene_name_id<>en2gn2.gene_name_id
      AND g1.gene_name_id=en2gn1.gene_name_id
      GROUP BY accession;

/**%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/


-- QUestion E
SELECT prn2pr.accession,prn.name_kind,prn.prot_name
FROM protein_names prn, prot_name_2_prot prn2pr, 
WHERE prn.prot_name LIKE '%channel%'
      AND prn.prot_name_id=prn2pr.prot_name_id;

/**%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/


-- QUestion F
SELECT en2kw.accession, prn.prot_name
FROM entries_2_keywords en2w, prot_name_2_prot prn2pr
WHERE en2kw.kw_id='Short QT syndrome'
       OR en2kw.kw_id='Long QT syndrome' 
       AND en2kw.accession=prn2pr.accession
       AND prn.prot_name_id=prn2pr.prot_name_id
       AND prn.name_kind='recommendedName';

/**%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/


-- QUestion G
SELECT dbref.db_ref  
FROM dbref, dbref dr, entries_2_keywords ek, keywords k 
WHERE dbref.accession = ek.accession 
       AND ek.kw_id = k.kw_id
       AND k.kw_label= 'LONG QT syndrome' 
       AND dr.accession = dbref.accession 
       AND dbref.db_ref != dr.db_ref ;



       




      
      
       
