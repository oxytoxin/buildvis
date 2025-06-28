import * as THREE from 'three';

export interface HollowBoxOptions {
    width: number;
    height: number;
    length: number;
    wallThickness: number;
    color: string;
    windowWidth?: number;
    windowHeight?: number;
    windows?: {
        front?: [number, number, number];
        back?: [number, number, number];
        left?: [number, number, number];
        right?: [number, number, number];
    };
}

export const createHollowBox = (options: HollowBoxOptions): THREE.Group => {
    const {
        width,
        height,
        length,
        wallThickness,
        color,
        windowWidth = 1.2,
        windowHeight = 1.0,
        windows = {}
    } = options;

    // Create outer and inner geometries
    const outerGeometry = new THREE.BoxGeometry(width, height, length);
    const innerGeometry = new THREE.BoxGeometry(
        width - (2 * wallThickness),
        height - (2 * wallThickness),
        length - (2 * wallThickness)
    );

    // Create a single geometry by combining outer and inner
    const geometry = new THREE.BufferGeometry();
    const outerPositions = outerGeometry.attributes.position.array;
    const innerPositions = innerGeometry.attributes.position.array;
    const outerIndices = outerGeometry.index?.array || [];
    const innerIndices = innerGeometry.index?.array || [];

    // Combine vertices and indices
    const positions = new Float32Array(outerPositions.length + innerPositions.length);
    const indices = new Uint32Array(outerIndices.length + innerIndices.length);

    // Copy outer geometry
    positions.set(outerPositions, 0);
    indices.set(outerIndices, 0);

    // Copy inner geometry with offset
    positions.set(innerPositions, outerPositions.length);
    for (let i = 0; i < innerIndices.length; i++) {
        indices[outerIndices.length + i] = innerIndices[i] + outerPositions.length / 3;
    }

    geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    geometry.setIndex(new THREE.BufferAttribute(indices, 1));
    geometry.computeVertexNormals();

    // Create a group to hold the room, edge lines, and windows
    const group = new THREE.Group();

    // Create the main room mesh
    const mesh = new THREE.Mesh(
        geometry,
        new THREE.MeshStandardMaterial({
            color: color,
            side: THREE.DoubleSide
        })
    );
    group.add(mesh);

    // Create edge lines
    const edges = new THREE.EdgesGeometry(outerGeometry);
    const lineMaterial = new THREE.LineBasicMaterial({ color: 'black', linewidth: 2 });
    const wireframe = new THREE.LineSegments(edges, lineMaterial);
    group.add(wireframe);

    // Create inner edge lines
    const innerEdges = new THREE.EdgesGeometry(innerGeometry);
    const innerWireframe = new THREE.LineSegments(innerEdges, lineMaterial);
    group.add(innerWireframe);

    // Create windows using pre-calculated positions
    const createWindow = (windowPosition: [number, number, number], rotation: number) => {
        // Create double window (side by side)
        const singleWindowWidth = (windowWidth - wallThickness * 0.1) / 2; // Half width minus small gap
        const dividerThickness = wallThickness * 0.1; // Thickness of divider

        // Create window group
        const windowGroup = new THREE.Group();

        // Left window
        const leftWindowGeometry = new THREE.BoxGeometry(singleWindowWidth, windowHeight, wallThickness * 1.5);
        const leftWindowMaterial = new THREE.MeshStandardMaterial({
            color: '#87CEEB', // Light blue for glass
            transparent: true,
            opacity: 0.8,
            side: THREE.DoubleSide
        });
        const leftWindow = new THREE.Mesh(leftWindowGeometry, leftWindowMaterial);
        leftWindow.position.set(-singleWindowWidth / 2 - dividerThickness / 2, 0, 0);
        windowGroup.add(leftWindow);

        // Right window
        const rightWindowGeometry = new THREE.BoxGeometry(singleWindowWidth, windowHeight, wallThickness * 1.5);
        const rightWindowMaterial = new THREE.MeshStandardMaterial({
            color: '#87CEEB', // Light blue for glass
            transparent: true,
            opacity: 0.8,
            side: THREE.DoubleSide
        });
        const rightWindow = new THREE.Mesh(rightWindowGeometry, rightWindowMaterial);
        rightWindow.position.set(singleWindowWidth / 2 + dividerThickness / 2, 0, 0);
        windowGroup.add(rightWindow);

        // Vertical divider line between windows
        const dividerGeometry = new THREE.BoxGeometry(dividerThickness, windowHeight, wallThickness * 1.5);
        const dividerMaterial = new THREE.MeshStandardMaterial({
            color: '#1a1a1a', // Dark gray for frame
            side: THREE.DoubleSide
        });
        const divider = new THREE.Mesh(dividerGeometry, dividerMaterial);
        divider.position.set(0, 0, 0);
        windowGroup.add(divider);

        // Position and rotate the entire window group
        windowGroup.position.set(windowPosition[0], windowPosition[1], windowPosition[2]);
        windowGroup.rotation.y = rotation;
        group.add(windowGroup);
    };

    // Add windows using pre-calculated positions
    if (windows.front) {
        createWindow(windows.front, 0); // Front window
    }
    if (windows.back) {
        createWindow(windows.back, 0); // Back window
    }
    if (windows.left) {
        createWindow(windows.left, Math.PI / 2); // Left window
    }
    if (windows.right) {
        createWindow(windows.right, Math.PI / 2); // Right window
    }

    return group;
}; 