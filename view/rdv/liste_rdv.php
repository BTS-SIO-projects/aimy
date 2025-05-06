 <?php

    include('controller/rdv/listeRdvController.php');

    ?>
 <center class="table-container">
     <?php if (count($lesRdvs) != 0) {  ?>
         <h3>Liste des Rendez-Vous</h3>
         <p>Nombre total de rendez-vous : <strong><?php echo count($lesRdvs); ?></strong></p>
         <!--
         <form action="controller/rdv/exportCsv.php" method="post" style="margin-bottom: 10px;">
             <button type="submit">📤 Exporter en CSV</button>
         </form>
     -->
         <table>
             <tr>
                 <td> Date RDV </td>
                 <td> Heure RDV </td>
                 <td> Motif </td>
                 <td> Nom </td>
                 <td> Lieu </td>
                 <td> Actions </td>
             </tr>
         <?php } else {
            echo "<h1>Vous n'avez aucun rendez-vous</h1> <br> <a id='listeRdvLink' href='index.php?page=rdv'>Prendre rendez-vous</a>";
        }  ?>
         <?php
            foreach ($lesRdvs as $unRdv) {
                $documents = $document->selectDocumentsByRdv($unRdv['idrdv']); // Récupérer les documents liés au RDV

                if (isset($_SESSION['idpatient'])) {
                    $personne = $medecin->selectWhereMedecin($unRdv['idmedecin']);
                } else {
                    $personne = $patient->selectWherePatient($unRdv['idpatient']);
                }
                $Lieu = $lieu->selectWhereLieu($unRdv['idlieu']);
                /*
                // Détermine la classe CSS pour la ligne
                $rowClass = "";
                if ($unRdv['statut'] === 'en attente') {
                    $rowClass = "row-en-attente";
                } elseif ($unRdv['statut'] === 'valider') {
                    $rowClass = "row-valider";
                } elseif ($unRdv['statut'] === 'refuser') {
                    $rowClass = "row-refuser";
                }
                */
            ?>
             <tr class="<?php echo $rowClass; ?>">
                 <td><?php echo $unRdv['daterdv']; ?></td>
                 <td><?php echo $unRdv['heureRdv']; ?></td>
                 <td><?php echo $unRdv['motif']; ?></td>
                 <td><?php echo $personne['nom'] . " " . $personne['prenom']; ?></td>
                 <td><?php echo $Lieu['typeLieu'] . " " . $Lieu['nom'] . " " . $Lieu['adresse']; ?></td>
                 <td>
                     <button type="button" class="toggle-docs" data-id="<?php echo $unRdv['idrdv']; ?>">Voir documents</button>
                 </td>
                 <td>
                     <form action="controller/rdv/listeRdvController.php" method="POST">
                         <input type="hidden" name="action" value="supprimer">
                         <button type="submit" name="idrdv" value="<?php echo $unRdv['idrdv']; ?>" id="supprimerRdv">Supprimer</button>
                     </form>
                 </td>
                 <?php /* if (isset($_SESSION['idmedecin'])) { ?>
                     <td>
                         <form action="controller/rdv/listeRdvController.php" method="POST">
                             <input type="hidden" name="action" value="valider">
                             <button type="submit" name="idrdv" value="<?php echo $unRdv['idrdv']; ?>">Valider</button>
                         </form>
                     </td>
                     <td>
                         <form action="controller/rdv/listeRdvController.php" method="POST">
                             <input type="hidden" name="action" value="refuser">
                             <button type="submit" name="idrdv" value="<?php echo $unRdv['idrdv']; ?>">Refuser</button>
                         </form>
                     </td>
                 <?php } */ ?>
             </tr>
             <tr class="documents-row" id="docs-<?php echo $unRdv['idrdv']; ?>" style="display: none;">
                 <td colspan="6">
                     <ul>
                         <?php if (!empty($documents)) {
                                foreach ($documents as $doc) { ?>
                                 <li>
                                     <a href="<?php echo htmlspecialchars($doc['url']); ?>" target="_blank">
                                         📄 <?php echo htmlspecialchars($doc['typeDoc']); ?>
                                     </a> - <?php echo htmlspecialchars($doc['description']); ?>
                                 </li>
                             <?php }
                            } else { ?>
                             <li>Aucun document disponible.</li>
                         <?php } ?>
                     </ul>
                 </td>
             </tr>

         <?php
            }
            ?>
         </table>
 </center>

 <!--  à deplacer dans script.js  -->
 <script>
     document.addEventListener("DOMContentLoaded", function() {
         document.querySelectorAll(".toggle-docs").forEach(button => {
             button.addEventListener("click", function() {
                 let idRdv = this.getAttribute("data-id");
                 let row = document.getElementById("docs-" + idRdv);
                 if (row.style.display === "none") {
                     row.style.display = "table-row";
                     this.textContent = "Masquer documents";
                 } else {
                     row.style.display = "none";
                     this.textContent = "Voir documents";
                 }
             });
         });
     });
 </script>