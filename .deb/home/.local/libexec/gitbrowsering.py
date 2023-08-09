import requests

def get_github_links(keyword):
    url = f"https://api.github.com/search/repositories?q={keyword}&per_page=100"
    links = []

    while url:
        response = requests.get(url)
        if response.status_code == 200:
            data = response.json()
            repositories = data.get('items', [])
            if not repositories:
                break
            links.extend(repo['html_url'] for repo in repositories)
            if 'next' in response.links:
                url = response.links['next']['url']
            else:
                url = None
        else:
            print(f"Error: No se pudo obtener la información de GitHub. Código de estado: {response.status_code}")
            break

    return links

def print_debugsec_ascii():
    ascii_art = r'''
     ▄▄ • ▪  ▄▄▄▄▄▄▄▄▄· ▄▄▄        ▄▄▌ ▐ ▄▌.▄▄ · ▄▄▄ .▄▄▄  ▪   ▐ ▄  ▄▄ • 
    ▐█ ▀ ▪██ •██  ▐█ ▀█▪▀▄ █·▪     ██· █▌▐█▐█ ▀. ▀▄.▀·▀▄ █·██ •█▌▐█▐█ ▀ ▪
    ▄█ ▀█▄▐█· ▐█.▪▐█▀▀█▄▐▀▀▄  ▄█▀▄ ██▪▐█▐▐▌▄▀▀▀█▄▐▀▀▪▄▐▀▀▄ ▐█·▐█▐▐▌▄█ ▀█▄
    ▐█▄▪▐█▐█▌ ▐█▌·██▄▪▐█▐█•█▌▐█▌.▐▌▐█▌██▐█▌▐█▄▪▐█▐█▄▄▌▐█•█▌▐█▌██▐█▌▐█▄▪▐█
    ·▀▀▀▀ ▀▀▀ ▀▀▀ ·▀▀▀▀ .▀  ▀ ▀█▄▀▪ ▀▀▀▀ ▀▪ ▀▀▀▀  ▀▀▀ .▀  ▀▀▀▀▀▀ █▪·▀▀▀▀ 
    '''
    print(ascii_art)
    print("BY DEBUGSEC ENTERPRISE\n")

if __name__ == "__main__":
    print_debugsec_ascii()
    keyword = input("Introduce una palabra clave para buscar repositorios en GitHub: ")
    links = get_github_links(keyword)

    if links:
        print(f"Enlaces a repositorios relacionados con '{keyword}':")
        for link in links:
            print(link)
        print(f"\nTotal de enlaces encontrados: {len(links)}\n")
    else:
        print("No se encontraron repositorios relacionados con la palabra clave ingresada.")
