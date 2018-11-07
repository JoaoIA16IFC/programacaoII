const main = document.querySelector('main')
const header=main.querySelector('header')
const section = main.querySelector('section')
const ul = header.querySelector('ul')
let categorias = []
let scrollY
let lastClicked = document.createElement('li')
getCategorias()
getPosts()
async function getCategorias() {
    const req = await fetch('http://127.0.0.1/api/categoria/read.php')
    const resp = await req.json()
    resp.forEach(cat => {
        categorias.push(cat.nome)
        const li = document.createElement('li')
        let i
        if(window.innerWidth/window.innerHeight>1){
            li.innerText = cat.nome
        }else{
            i = document.createElement('i')
            i.classList = cat.icone
            li.appendChild(i)
        }
        li.addEventListener('click',()=>{
            getPosts({categoria:cat.id})
            li.style.backgroundColor = '#1b272c'
            reset(li)
            i.style.fontSize = '1.7em'
        })
        ul.appendChild(li)
    })
}
function reset(li){
    lastClicked.style.backgroundColor = '#273941'
    console.log(lastClicked)
    const i=lastClicked.querySelector('i')
    if(i)
        i.style.fontSize = '1.2em'
    lastClicked = li   
}
async function getPosts(idObject={}){
    let option
    let url = 'http://127.0.0.1/api/post/read.php'
    if(idObject.categoria) option = '?idcat='+idObject.categoria
    if(idObject.post) option = '?idpost='+idObject.post
    if(option!=null) url+=option
    const req = await fetch(url)
    const resp = await req.json()
    buildPosts(resp)
}
function buildPosts(posts){
    section.innerHTML = ''
    posts.forEach(post=>{
        const div = document.createElement('div')
        div.classList = 'post'
        div.addEventListener('click',()=>{
            createOverlay(post)
        })
        const p = document.createElement('p')
        p.innerText = post.titulo
        const span = document.createElement('span')
        span.innerText = post.autor
        div.appendChild(span)
        div.appendChild(p)
        section.appendChild(div)
    })
}
function createOverlay(post){
    const overlay = document.createElement('div')
    overlay.classList = 'overlay'
    const wrapper = document.createElement('div')
    wrapper.classList = 'wrapper'
    const h1 = document.createElement('h1')
    h1.innerText = post.titulo
    const span = document.createElement('span')
    span.innerText = post.autor
    const h2 = document.createElement('h2')
    h2.innerText = post.dt_criacao.substring(8,10) + '/' + post.dt_criacao.substring(5,7)+'/'+post.dt_criacao.substring(0,4)+' - '+post.dt_criacao.substring(11,post.dt_criacao.length-3)
    const p = document.createElement('p')
    p.innerText = post.texto
    const icon = document.createElement('i')
    icon.classList = 'fas fa-times'
    wrapper.appendChild(icon)
    wrapper.appendChild(h1)
    wrapper.appendChild(span)
    wrapper.appendChild(h2)
    wrapper.appendChild(p)
    overlay.appendChild(wrapper)
    main.appendChild(overlay)
    scrollY = window.scrollY
    document.addEventListener('scroll',stopScroll)
    icon.addEventListener('click',()=>{
        main.removeChild(overlay)
        document.removeEventListener('scroll',stopScroll)
    })
    overlay.addEventListener('click',(ev)=>{
        if(!ev.path.includes(wrapper)){
            main.removeChild(overlay)
            document.removeEventListener('scroll',stopScroll)
        }
    },true)
}
function stopScroll(){
    window.scrollTo({},scrollY)
}