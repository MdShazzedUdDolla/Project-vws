function fix_resolution(){
    var displayWidth = 1280;
    var displayHeight = 739;
    var canvas = document.getElementById("graph");
    var scale = 2;
    canvas.style.width = displayWidth + 'px';
    canvas.style.height = displayHeight + 'px';
    canvas.width = displayWidth * scale;
    canvas.height = displayHeight * scale;
    var ctx = canvas.getContext("2d");

    var drawing = false;
    var mousePos = { x:0, y:0 };
    var lastPos = mousePos;
    canvas.addEventListener("mousemove", function (e) {
      mousePos = getMousePos(canvas, e);
        drawing = false;
    }, false);

    // Get the position of the mouse relative to the canvas
    function getMousePos(canvasDom, mouseEvent) {
      var rect = canvasDom.getBoundingClientRect();
      return {
        x: (mouseEvent.clientX - rect.left) * scale,
        y: (mouseEvent.clientY - rect.top) * scale
      };
    }

    // Get a regular interval for drawing to the screen
    window.requestAnimFrame = (function (callback) {
            return window.requestAnimationFrame || 
              window.webkitRequestAnimationFrame ||
              window.mozRequestAnimationFrame ||
              window.oRequestAnimationFrame ||
              window.msRequestAnimaitonFrame ||
              function (callback) {
            window.setTimeout(callback, 1000/60);
              };
    })();

    // Draw to the canvas
    function renderCanvas() {
      if (drawing) {
        ctx.fillStyle = "#FFFFFF";
        ctx.fillRect(mousePos.x, mousePos.y, 25, 25);

        ctx.strokeStyle = "#000000";
        ctx.lineWidth   = 2;
        ctx.strokeRect(mousePos.x, mousePos.y, 25, 25);
        lastPos = mousePos;
      }
    }

    // Allow for animation
    (function drawLoop () {
      requestAnimFrame(drawLoop);
      renderCanvas();
    })();

    return canvas;
}