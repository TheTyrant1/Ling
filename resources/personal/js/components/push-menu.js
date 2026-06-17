import {
    onDOMContentLoaded
} from '../util'

const DATA_KEY = 'push-menu'
const EVENT_KEY = `.${DATA_KEY}`
const EVENT_OPEN = `open${EVENT_KEY}`
const EVENT_COLLAPSE = `collapse${EVENT_KEY}`

const CLASS_NAME_SIDEBAR_MINI = 'sidebar-mini'
const CLASS_NAME_SIDEBAR_EXPAND = 'sidebar-expand'
const CLASS_NAME_SIDEBAR_OVERLAY = 'sidebar-overlay'

const CLASS_NAME_SIDEBAR_COLLAPSE = 'sidebar-collapse'
const CLASS_NAME_SIDEBAR_OPEN = 'sidebar-open'

const SELECTOR_APP_SIDEBAR = '.app-sidebar'
const SELECTOR_APP_WRAPPER = '.app-wrapper'
const SELECTOR_SIDEBAR_EXPAND = `[class*="${CLASS_NAME_SIDEBAR_EXPAND}"]`
const SELECTOR_SIDEBAR_TOGGLE = '[data-toggle="sidebar"]'

const STORAGE_KEY_SIDEBAR_STATE = 'sidebar.state'

const Defaults = {
    sidebarBreakpoint: 992,
    enablePersistence: false
}

class PushMenu {
    constructor(element, config) {
        this._element = element
        this._config = { ...Defaults, ...config }
    }

    isCollapsed() {
        return document.body.classList.contains(CLASS_NAME_SIDEBAR_COLLAPSE)
    }

    isExplicitlyOpen() {
        return document.body.classList.contains(CLASS_NAME_SIDEBAR_OPEN)
    }

    isMiniMode() {
        return document.body.classList.contains(CLASS_NAME_SIDEBAR_MINI)
    }

    isMobileSize() {
        return globalThis.innerWidth <= this._config.sidebarBreakpoint
    }

    expand() {
        document.body.classList.remove(CLASS_NAME_SIDEBAR_COLLAPSE)

        if (this.isMobileSize()) {
            document.body.classList.add(CLASS_NAME_SIDEBAR_OPEN)
        }

        this._element.dispatchEvent(new Event(EVENT_OPEN))
    }

    collapse() {
        document.body.classList.remove(CLASS_NAME_SIDEBAR_OPEN)
        document.body.classList.add(CLASS_NAME_SIDEBAR_COLLAPSE)

        this._element.dispatchEvent(new Event(EVENT_COLLAPSE))
    }

    toggle() {
        const isCollapsed = this.isCollapsed()

        if (isCollapsed) {
            this.expand()
        } else {
            this.collapse()
        }

        if (this._config.enablePersistence) {
            this.saveSidebarState(
                isCollapsed ? CLASS_NAME_SIDEBAR_OPEN : CLASS_NAME_SIDEBAR_COLLAPSE
            )
        }
    }

    setupSidebarBreakPoint() {
        const sidebarExpand = document.querySelector(SELECTOR_SIDEBAR_EXPAND)

        if (!sidebarExpand) {
            return
        }

        const content = globalThis.getComputedStyle(sidebarExpand, '::before')
            .getPropertyValue('content')

        if (!content || content === 'none') {
            return
        }

        const breakpointValue = Number(content.replace(/[^\d.-]/g, ''))

        if (Number.isNaN(breakpointValue)) {
            return
        }

        this._config = { ...this._config, sidebarBreakpoint: breakpointValue }
    }

    updateStateByResponsiveLogic() {
        if (this.isMobileSize()) {
            if (!this.isExplicitlyOpen()) {
                this.collapse()
            }
        } else {
            if (!(this.isMiniMode() && this.isCollapsed())) {
                this.expand()
            }
        }
    }

    saveSidebarState(state) {
        if (globalThis.localStorage === undefined) {
            return
        }

        try {
            localStorage.setItem(STORAGE_KEY_SIDEBAR_STATE, state)
        } catch {

        }
    }

    loadSidebarState() {
        if (globalThis.localStorage === undefined) {
            return
        }

        try {
            const storedState = localStorage.getItem(STORAGE_KEY_SIDEBAR_STATE)

            if (storedState === CLASS_NAME_SIDEBAR_COLLAPSE) {
                this.collapse()
            } else if (storedState === CLASS_NAME_SIDEBAR_OPEN) {
                this.expand()
            } else {
                this.updateStateByResponsiveLogic()
            }
        } catch {
            this.updateStateByResponsiveLogic()
        }
    }

    clearSidebarState() {
        if (globalThis.localStorage === undefined) {
            return
        }

        try {
            localStorage.removeItem(STORAGE_KEY_SIDEBAR_STATE)
        } catch {

        }
    }

    init() {
        this.setupSidebarBreakPoint()

        if (!this._config.enablePersistence) {
            this.clearSidebarState()
        }

        if (this._config.enablePersistence && !this.isMobileSize()) {
            this.loadSidebarState()
        } else {
            this.updateStateByResponsiveLogic()
        }
    }
}

onDOMContentLoaded(() => {
    const sidebar = document?.querySelector(SELECTOR_APP_SIDEBAR)

    if (!sidebar) {
        return
    }

    const sidebarBreakpointAttr = sidebar.dataset.sidebarBreakpoint
    const enablePersistenceAttr = sidebar.dataset.enablePersistence

    const config = {
        sidebarBreakpoint: sidebarBreakpointAttr === undefined ?
            Defaults.sidebarBreakpoint :
            Number(sidebarBreakpointAttr),
        enablePersistence: enablePersistenceAttr === undefined ?
            Defaults.enablePersistence :
            enablePersistenceAttr === 'true'
    }

    const pushMenu = new PushMenu(sidebar, config)
    pushMenu.init()

    window.addEventListener('resize', () => {
        pushMenu.setupSidebarBreakPoint()
        pushMenu.updateStateByResponsiveLogic()
    })

    const sidebarOverlay = document.createElement('div')
    sidebarOverlay.className = CLASS_NAME_SIDEBAR_OVERLAY
    document.querySelector(SELECTOR_APP_WRAPPER)?.append(sidebarOverlay)

    let overlayTouchMoved = false

    sidebarOverlay.addEventListener('touchstart', () => {
        overlayTouchMoved = false
    }, { passive: true })

    sidebarOverlay.addEventListener('touchmove', () => {
        overlayTouchMoved = true
    }, { passive: true })

    sidebarOverlay.addEventListener('touchend', event => {
        if (!overlayTouchMoved) {
            event.preventDefault()
            pushMenu.collapse()
        }

        overlayTouchMoved = false
    }, { passive: false })

    sidebarOverlay.addEventListener('click', event => {
        event.preventDefault()
        pushMenu.collapse()
    })

    const fullBtn = document.querySelectorAll(SELECTOR_SIDEBAR_TOGGLE)

    fullBtn.forEach(btn => {
        btn.addEventListener('click', event => {
            event.preventDefault()

            let button = event.currentTarget

            if (button?.dataset.appToggle !== 'sidebar') {
                button = button?.closest(SELECTOR_SIDEBAR_TOGGLE)
            }

            if (button) {
                event?.preventDefault()
                pushMenu.toggle()
            }
        })
    })
})

export default PushMenu
