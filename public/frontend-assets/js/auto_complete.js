function autocomplete (input) {
    const controller = new AbortController();
    //Add an event listener to compare the input value with all countries
    input.addEventListener('input',async function () {
        // controller.abort();
        //Close the existing list if it is open
        closeList();
        //If the input is empty, exit the function
        if (!this.value){
            closeList();
            return;
        }
        if(this.value ==' '){
            closeList();
            return false;
        }

        $(".searchbar").addClass('home-page-searchbar');
        const response =  await fetch(site_url+"/sugesstion-destination",{
            signal: controller.signal,
            method: "POST",
            headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
            "Content-Type": "application/json",
        },
        contentType: false,
        processData: false,
        body: JSON.stringify({ value: this.value }),
        })
        const results = await response.json();
        //Create a suggestions <div> and add it to the element containing the input field
        let suggestion = document.getElementById('suggestions');
        if(suggestion ==null){
            suggestions = document.createElement('div');
            suggestions.setAttribute('id', 'suggestions');
            this.parentNode.appendChild(suggestions);
        }
        
        //Iterate through all entries in the list and find matches
        if(results.data.length =='0'){
            closeList();
        }
        suggestions.innerHTML ='';
        for (let i=0; i < results.data.length; i++) {
            if (results.data[i].toUpperCase().includes(this.value.toUpperCase())) {
                //If a match is found, create a suggestion <div> and add it to the suggestions <div>
                suggestion = document.createElement('div');
                suggestion.innerHTML=' ';
                suggestion.innerHTML = results.data[i];
                suggestion.addEventListener('click', function () {
                    input.value = this.innerHTML;
                    closeList();
                });
                suggestion.style.cursor = 'pointer';
                suggestions.appendChild(suggestion);
            }
        }

    });

    function closeList() {
        let suggestions = document.getElementById('suggestions');
        if (suggestions){
            suggestions.parentNode.removeChild(suggestions);
            $(".searchbar").removeClass('home-page-searchbar');
        }
    }

    $(document).on("click",function(){
        closeList();
    })
}