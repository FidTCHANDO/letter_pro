$.fn.animateNumber = function(targetValue, duration) {
        // Save the element reference and starting value
        var $this = $(this);
        $({ count: 0 }).animate(
            { count: targetValue }, 
            {
                duration: duration,  // Animation duration
                easing: 'swing',     // Easing function for smoothness
                step: function() {
                    // Update the number on each step
                    $this.text(Math.floor(this.count) > 9 ? Math.floor(this.count) : "0"+Math.floor(this.count));
                },
                complete: function() {
                    // Ensure the final value is accurate
                    $this.text(targetValue);
                }
            }
        );
    };