// infinite scroll

    let postTime = ''
    let lastPostTime = ''
    let lastFetchTime = ''

window.onscroll = function() {
    
    const bodyHeight  = document.body.scrollHeight
    const scrollPoint = window.scrollY + window.innerHeight
    // const tolerantDistance = 100

    postTime = document.getElementsByClassName('post_time')
    lastPostTime = postTime[postTime.length - 1].value

    if(scrollPoint >= bodyHeight){
    
        if(lastFetchTime != lastPostTime){
            fetch('/loadmore/' + lastPostTime)
                .then(response => response.json())
                .then(data => {
                    console.log('load more..')
                    lastFetchTime = lastPostTime

                    for (let i = 0; i <data.post.length; i++) {
                        let newPost = renderPost(data.post[i])   
                        document.getElementById('post-wrapper').insertAdjacentHTML('beforeend', newPost)                   
                    }

                })
                .catch(err => console.log(err))
        }
    }
}

function getAvatar(user) {
    let avatar_url = (user.avatar != null)
                    ? "/images/avatar/" + user.avatar
                    : "https://ui-avatars.com/api/?size128&name="+ user.username;

    return `<img src="${avatar_url}" class="rounded-circle"
                alt="Foto profil ${user.username}" width="32" height="32">`
    
}

function renderPost(post) {
    const avatar = getAvatar(post.user)
    return `<div>
                <div>
                    <p>
                        ${avatar}
                        <a href="/@${post.user.username}"> @${post.user.username}</a>
                    </p>

                    <img src="/images/posts/${post.image}" alt="${post.caption}"
                        width="100%" height="auto" ondblclick="like(${post.id})"/> 
                    
                    <p>
                        <span class="captions"> ${(post.caption != null) ? post.caption : ''}</span>
                    </p>

                    <p> <small> ${post.created_at} </small></p>

                    <span class="total_count" id="post-likescount-${post.id}">
                        ${post.likes_count}
                    </span>

                    <a class="text-dark" onclick="like(${post.id})" id="post-btn-${post.id}">
                        ${post.like_status}
                    </a> -

                    <a class="text-dark" href="/post/${post.id}">Comment</a>
                </div>
                <input type="hidden" class="post_time" value="${post.post_time}">
                <br>
            </div>`

}



// finding hashtag
document.querySelectorAll(".captions").forEach(function(el){
    let renderedText = el.innerHTML.replace(/#(\w+)/g, "<a href='/search?query=%23$1'>#$1</a>");
    el.innerHTML = renderedText
})
        
function like(id, type='POST'){
    let likesCount = 0
    let el = ''
        
    if(type == 'POST'){
        el = document.getElementById('post-btn-' + id)
        likesCount = document.getElementById('post-likescount-' + id)
    }else{
        el = document.getElementById('comment-btn-' + id)
        likesCount = document.getElementById('comment-likescount-' + id)
    }
 
    
    fetch('/like/' + type + '/' + id)
        .then(response => response.json())
        .then(data => {
            let currentCount = 0

            if (data.status == 'LIKE'){
                currentCount = parseInt(likesCount.innerHTML) + 1
                el.innerText = 'unlike'
            }else{
                currentCount = parseInt(likesCount.innerHTML) - 1
                el.innerText = 'like'
            }

            likesCount.innerHTML = currentCount
        });

        return false
    }