          <div class="form-container">
              <form method="GET" action="index.php">
                  <input type="hidden" name="page" value="recherche_medecins">
                  <label for="specialite">Rechercher un médecin par spécialité :</label>
                  <input type="text" name="specialite" placeholder="ex: Cardiologue">
                  <button type="submit">Rechercher</button>
              </form>
              <h3>Résultats de recherche pour : "<?php echo htmlspecialchars($specialite); ?>"</h3>

              <?php if (count($medecins) > 0): ?>
                  <ul>
                      <?php foreach ($medecins as $doc): ?>
                          <li>
                              Dr <?php echo $doc['nom']; ?> — <?php echo $doc['categorie']; ?>
                              <a href="index.php?page=rdv">Prendre RDV</a>
                          </li>
                      <?php endforeach; ?>
                  </ul>
              <?php else: ?>
                  <p>Aucun médecin trouvé pour cette spécialité.</p>
              <?php endif; ?>
          </div>