
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Passenger stepper component
Alpine.data('passengerStepper', (initial = 1, min = 1, max = 4) => ({
    count: initial,
    min,
    max,
    increment() {
        if (this.count < this.max) this.count++;
    },
    decrement() {
        if (this.count > this.min) this.count--;
    },
}));

// Seat map component
Alpine.data('seatMap', (maxSeats = 1, occupiedSeats = [], blockedSeats = []) => ({
    selected: [],
    occupied: occupiedSeats,
    blocked: blockedSeats,
    maxSeats,

    init() {
        // Expose for polling script to update in real-time
        window.seatMapData = this;
    },

    toggle(seatId) {
        if (this.isOccupied(seatId) || this.isBlocked(seatId)) return;
        if (this.isSelected(seatId)) {
            this.selected = this.selected.filter(s => s !== seatId);
        } else if (this.selected.length < this.maxSeats) {
            this.selected.push(seatId);
        }
    },

    isSelected(seatId) {
        return this.selected.includes(seatId);
    },

    isOccupied(seatId) {
        return this.occupied.includes(seatId);
    },

    isBlocked(seatId) {
        return this.blocked.includes(seatId);
    },
}));

Alpine.start();
