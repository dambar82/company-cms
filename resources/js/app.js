//import './bootstrap';

document.addEventListener("moonshine:init", () => {
    MoonShine.onCallback('myResponse', function(data, messageType, component) {
        document.getElementById('add-inputs').insertAdjacentHTML('beforeend', data.html);
    });
})

function deleteElement() {
   console.log('test')
}
