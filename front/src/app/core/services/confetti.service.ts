import { ElementRef, Injectable } from '@angular/core';
import * as confetti from 'canvas-confetti';
import { timer } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ConfettiService {

  target: ElementRef;
  options: {};

  constructor() { }

  shoot(type: ConfettiType, target: ElementRef = null, options = {}) {
    [this.target, this.options] = [target, options];
    this[type]();
  }

  get launcher() {
    return confetti.create(this.target, this.target ? { resize: true } : {});
  }

  private schoolPride() {
    const launcher = this.launcher;

    launcher({
      particleCount: 200,
      angle: 50,
      spread: 60,
      origin: {
        x: 0,
        y: 1,
      },
    });

    launcher({
      particleCount: 200,
      angle: 130,
      spread: 60,
      origin: {
        x: 1,
        y: 1,
      },
    });
  }

  private snow() {
    const launcher = this.launcher;

    timer(0, 50).subscribe(() => {
      launcher({
        particleCount: 1,
        startVelocity: 0,
        ticks: 300,
        origin: {
          x: Math.random(),
          y: Math.random() - 0.2
        },
        colors: ['#ffffff'],
        shapes: ['circle']
      });
    });
  }

  private fireworks() {
    const launcher = this.launcher;

    timer(0, 1000).subscribe(() => {
      launcher({
        startVelocity: 30,
        spread: 360,
        ticks: 100,
        shapes: ['square'],
        origin: {
          x: Math.random(),
          y: Math.random() - 0.2
        }
      });
    });
  }


}

export enum ConfettiType {
  SchoolPride = 'schoolPride',
  Snow = 'snow',
  Fireworks = 'fireworks'
}
