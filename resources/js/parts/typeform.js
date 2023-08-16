$(function() {
    var qs,
        js,
        q,
        s,
        d = document,
        gi = d.getElementById,
        ce = d.createElement,
        gt = d.getElementsByTagName,
        id = "typef_orm",
        b = "https://embed.typeform.com/";
    if (
        window.location.pathname.indexOf("khalifahs-of-earth") === -1 &&
        window.location.pathname.indexOf("khalifahs") === -1
    ) {
        if (!gi.call(d, id)) {
            js = ce.call(d, "script");
            js.id = id;
            js.src = b + "embed.js";
            q = d.querySelector(".typeform-widget");
            if (q) {
                q.parentNode.appendChild(js);
            }
        }
    } else {
        let typeformFrame = document.querySelector(".typeform-widget iframe");
        typeformFrame.style.height = "900px";
        typeformFrame.style.width = "100%";
    }
});
