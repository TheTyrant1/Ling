import {
    onDOMContentLoaded
} from '../util'

const CLASS_NAME_HOLD_TRANSITIONS = 'hold-transition'
const CLASS_NAME_APP_LOADED = 'app-loaded'

class Layout {
    constructor(element) {
        this._element = element
        this._holdTransitionTimer = undefined
    }

    holdTransition(time = 100) {
        if (this._holdTransitionTimer) {
            clearTimeout(this._holdTransitionTimer)
        }

        document.body.classList.add(CLASS_NAME_HOLD_TRANSITIONS)

        this._holdTransitionTimer = setTimeout(() => {
            document.body.classList.remove(CLASS_NAME_HOLD_TRANSITIONS)
        }, time)
    }
}

onDOMContentLoaded(() => {
    const layout = new Layout(document.body)
    window.addEventListener('resize', () => layout.holdTransition(200))

    setTimeout(() => {
        document.body.classList.add(CLASS_NAME_APP_LOADED)
    }, 400)
})

export default Layout
