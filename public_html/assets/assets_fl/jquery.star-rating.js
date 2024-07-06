(function($){$.fn.starRating=function(setup){let settings=$.extend(!0,{wrapperClasses:'',starIconEmpty:'fa-regular fa-star',starIconFull:'fa-solid fa-star',starColorEmpty:'lightgray',starColorFull:'#000000',starsSize:1.5,stars:5,showInfo:!0,titles:["Very bad","Bad","Medium","Good","Very good"],inputName:'rating'},setup||{});$(this).each(function(i,e){return init($(e))});function getTextColor(value){switch(!0){case value<(settings.stars/3):return'var(--bs-danger)';case value<(settings.stars/3*2):return'var(--bs-warning)';default:return'var(--bs-success)'}}
    function init(wrapper){if(!wrapper.hasClass('js-wc-star-rating')){let starWrapper=$('<div>',{css:{'display':'flex','flex-wrap':'nowrap'}}).appendTo(wrapper);for(let i=1;i<=settings.stars;i++){$('<input>',{type:'radio',value:i,name:settings.inputName,css:{display:'none'}}).appendTo(starWrapper);$('<i>',{'data-index':i-1,title:settings.titles[i-1]||i+" Sterne",css:{color:settings.starColorEmpty,margin:'2px',fontSize:settings.starsSize+'em'},class:settings.starIconEmpty}).appendTo(starWrapper)}
        settings.wrapperClasses.split(' ').forEach(className=>{wrapper.addClass(className)});if(settings.showInfo){$('<strong>',{html:"0",class:'js-wc-rating-value',css:{fontSize:"1.5em"}}).insertAfter(starWrapper);$('<p>',{class:'js-wc-label',css:{marginTop:5,marginLeft:10,marginRight:10},html:"Rate us!"}).insertAfter(starWrapper)}
        wrapper.css({'display':'flex','justify-content':'between',})
        wrapper.addClass('js-wc-star-rating ');events(wrapper)}
        function events(wrapper){wrapper.on('click','i',function(e){let index=$(e.currentTarget).data('index'),value=index+1,titleIndex=Math.floor(settings.titles.length/settings.stars*index),label=settings.titles[titleIndex]||value+" Sterne";wrapper.find('input[type="radio"][value="'+value+'"]').prop('checked',!0);if(settings.showInfo){wrapper.find('.js-wc-rating-value').text(value).css('color',getTextColor(value));wrapper.find('.js-wc-label').text(label).css('color',getTextColor(value))}
            let allStars=wrapper.find('i').css('color',settings.starColorEmpty).removeClass(settings.starIconFull).addClass(settings.starIconEmpty);allStars.each(function(i,e){if(i<=index){$(e).removeClass(settings.starIconEmpty).addClass(settings.starIconFull).css('color',settings.starColorFull)}});wrapper.trigger('change',[value,index])})}
        return this}}}(jQuery))