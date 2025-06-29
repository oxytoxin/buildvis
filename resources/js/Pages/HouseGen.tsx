import { Canvas, useFrame, useThree } from '@react-three/fiber';
import { OrbitControls } from '@react-three/drei';
import { Suspense, useState, useMemo, useEffect, useRef } from 'react';
import { calculateRoomLayout, type Room, type HouseDimensions, type Story } from '../utils/roomLayout';
import { createHollowBox } from '../utils/hollowBox';
import * as THREE from 'three';

const Room = ({ position, dimensions, externalColor, internalColor, windows, outerWalls, internalWalls }: {
    position: [number, number, number];
    dimensions: [number, number, number];
    externalColor: string;
    internalColor: string;
    windows: {
        front?: [number, number, number];
        back?: [number, number, number];
        left?: [number, number, number];
        right?: [number, number, number];
    };
    outerWalls: {
        front: boolean;
        back: boolean;
        left: boolean;
        right: boolean;
    };
    internalWalls: {
        front: boolean;
        back: boolean;
        left: boolean;
        right: boolean;
    };
}) => {
    const wallThickness = 0.2; // 20cm wall thickness
    const [width, height, length] = dimensions;

    // Create individual wall meshes
    const createWall = (wallType: 'front' | 'back' | 'left' | 'right', isOuter: boolean) => {
        let wallGeometry: THREE.BoxGeometry;
        let wallPosition: [number, number, number];
        let wallRotation: [number, number, number] = [0, 0, 0];

        switch (wallType) {
            case 'front':
                wallGeometry = new THREE.BoxGeometry(width, height, wallThickness);
                wallPosition = [0, 0, -length / 2 + wallThickness / 2];
                break;
            case 'back':
                wallGeometry = new THREE.BoxGeometry(width, height, wallThickness);
                wallPosition = [0, 0, length / 2 - wallThickness / 2];
                break;
            case 'left':
                wallGeometry = new THREE.BoxGeometry(wallThickness, height, length);
                wallPosition = [-width / 2 + wallThickness / 2, 0, 0];
                break;
            case 'right':
                wallGeometry = new THREE.BoxGeometry(wallThickness, height, length);
                wallPosition = [width / 2 - wallThickness / 2, 0, 0];
                break;
        }

        const wall = new THREE.Mesh(wallGeometry);
        wall.position.set(...wallPosition);
        wall.rotation.set(...wallRotation);

        return wall;
    };

    // Create internal wall meshes (positioned slightly inward to avoid z-fighting)
    const createInternalWall = (wallType: 'front' | 'back' | 'left' | 'right') => {
        let wallGeometry: THREE.BoxGeometry;
        let wallPosition: [number, number, number];
        let wallRotation: [number, number, number] = [0, 0, 0];
        const offset = wallThickness * 0.1; // Small offset to prevent z-fighting

        switch (wallType) {
            case 'front':
                wallGeometry = new THREE.BoxGeometry(width - wallThickness * 2, height, wallThickness);
                wallPosition = [0, 0, -length / 2 + wallThickness * 1.5 + offset];
                break;
            case 'back':
                wallGeometry = new THREE.BoxGeometry(width - wallThickness * 2, height, wallThickness);
                wallPosition = [0, 0, length / 2 - wallThickness * 1.5 - offset];
                break;
            case 'left':
                wallGeometry = new THREE.BoxGeometry(wallThickness, height, length - wallThickness * 2);
                wallPosition = [-width / 2 + wallThickness * 1.5 + offset, 0, 0];
                break;
            case 'right':
                wallGeometry = new THREE.BoxGeometry(wallThickness, height, length - wallThickness * 2);
                wallPosition = [width / 2 - wallThickness * 1.5 - offset, 0, 0];
                break;
        }

        const wall = new THREE.Mesh(wallGeometry);
        wall.position.set(...wallPosition);
        wall.rotation.set(...wallRotation);

        return wall;
    };

    // Create interior wallpaper plane
    const createWallpaperPlane = (wallType: 'front' | 'back' | 'left' | 'right') => {
        let planeWidth: number, planeHeight: number;
        let planePosition: [number, number, number];
        let planeRotation: [number, number, number] = [0, 0, 0];

        switch (wallType) {
            case 'front':
                planeWidth = width - wallThickness * 2;
                planeHeight = height;
                planePosition = [0, 0, -length / 2 + wallThickness];
                break;
            case 'back':
                planeWidth = width - wallThickness * 2;
                planeHeight = height;
                planePosition = [0, 0, length / 2 - wallThickness];
                planeRotation = [0, Math.PI, 0];
                break;
            case 'left':
                planeWidth = length - wallThickness * 2;
                planeHeight = height;
                planePosition = [-width / 2 + wallThickness, 0, 0];
                planeRotation = [0, Math.PI / 2, 0];
                break;
            case 'right':
                planeWidth = length - wallThickness * 2;
                planeHeight = height;
                planePosition = [width / 2 - wallThickness, 0, 0];
                planeRotation = [0, -Math.PI / 2, 0];
                break;
        }

        const planeGeometry = new THREE.PlaneGeometry(planeWidth, planeHeight);
        const planeMaterial = new THREE.MeshStandardMaterial({
            color: internalColor,
            side: THREE.FrontSide
        });
        const plane = new THREE.Mesh(planeGeometry, planeMaterial);
        plane.position.set(...planePosition);
        plane.rotation.set(...planeRotation);

        return plane;
    };

    const group = new THREE.Group();

    // Add external walls (single color)
    if (outerWalls.front) {
        const wall = createWall('front', true);
        wall.material = new THREE.MeshStandardMaterial({ color: externalColor });
        wall.position.z -= 0.01; // Offset slightly outward
        group.add(wall);
    }
    if (outerWalls.back) {
        const wall = createWall('back', true);
        wall.material = new THREE.MeshStandardMaterial({ color: externalColor });
        wall.position.z += 0.01; // Offset slightly outward
        group.add(wall);
    }
    if (outerWalls.left) {
        const wall = createWall('left', true);
        wall.material = new THREE.MeshStandardMaterial({ color: externalColor });
        wall.position.x -= 0.01; // Offset slightly outward
        group.add(wall);
    }
    if (outerWalls.right) {
        const wall = createWall('right', true);
        wall.material = new THREE.MeshStandardMaterial({ color: externalColor });
        wall.position.x += 0.01; // Offset slightly outward
        group.add(wall);
    }

    // Add interior wallpaper planes
    if (outerWalls.front) group.add(createWallpaperPlane('front'));
    if (outerWalls.back) group.add(createWallpaperPlane('back'));
    if (outerWalls.left) group.add(createWallpaperPlane('left'));
    if (outerWalls.right) group.add(createWallpaperPlane('right'));

    // Add internal walls (both sides use internal color)
    if (internalWalls.front) {
        const wall = createWall('front', false);
        wall.material = new THREE.MeshStandardMaterial({ color: internalColor });
        group.add(wall);
    }
    if (internalWalls.back) {
        const wall = createWall('back', false);
        wall.material = new THREE.MeshStandardMaterial({ color: internalColor });
        group.add(wall);
    }
    if (internalWalls.left) {
        const wall = createWall('left', false);
        wall.material = new THREE.MeshStandardMaterial({ color: internalColor });
        group.add(wall);
    }
    if (internalWalls.right) {
        const wall = createWall('right', false);
        wall.material = new THREE.MeshStandardMaterial({ color: internalColor });
        group.add(wall);
    }

    // Add windows (only on external walls)
    const createWindow = (windowPosition: [number, number, number], rotation: number, wallType: 'front' | 'back' | 'left' | 'right') => {
        const windowWidth = 1.2;
        const windowHeight = 1.0;
        const paneThickness = wallThickness * 1.5;
        const gap = 0.05;

        // Calculate proper window position based on wall type
        let adjustedPosition = [...windowPosition] as [number, number, number];
        if (wallType === 'front') {
            adjustedPosition[2] = -length / 2 + wallThickness / 2;
        } else if (wallType === 'back') {
            adjustedPosition[2] = length / 2 - wallThickness / 2;
        } else if (wallType === 'left') {
            adjustedPosition[0] = -width / 2 + wallThickness / 2;
        } else if (wallType === 'right') {
            adjustedPosition[0] = width / 2 - wallThickness / 2;
        }

        // Create window group
        const windowGroup = new THREE.Group();

        // Create left pane
        const leftPaneGeometry = new THREE.BoxGeometry(windowWidth / 2 - 0.025, windowHeight, paneThickness);
        const windowMaterial = new THREE.MeshStandardMaterial({
            color: '#87CEEB',
            transparent: true,
            opacity: 0.8,
            side: THREE.DoubleSide
        });
        const leftPane = new THREE.Mesh(leftPaneGeometry, windowMaterial);
        leftPane.position.set(-windowWidth / 4, 0, -gap / 2);
        windowGroup.add(leftPane);

        // Create right pane
        const rightPaneGeometry = new THREE.BoxGeometry(windowWidth / 2 - 0.025, windowHeight, paneThickness);
        const rightPane = new THREE.Mesh(rightPaneGeometry, windowMaterial);
        rightPane.position.set(windowWidth / 4, 0, -gap / 2);
        windowGroup.add(rightPane);

        // Create black divider (positioned slightly in front to prevent z-fighting)
        const dividerWidth = 0.05;
        const dividerGeometry = new THREE.BoxGeometry(dividerWidth, windowHeight, paneThickness);
        const dividerMaterial = new THREE.MeshStandardMaterial({ color: '#000000' });
        const divider = new THREE.Mesh(dividerGeometry, dividerMaterial);
        divider.position.set(0, 0, -gap / 2 + 0.01);
        windowGroup.add(divider);

        // Position and rotate the entire window group
        windowGroup.position.set(adjustedPosition[0], adjustedPosition[1], adjustedPosition[2]);
        windowGroup.rotation.y = rotation;
        group.add(windowGroup);
    };

    // Check if window overlaps with door (only for the room containing the door)
    const isWindowOverlappingDoor = (windowPosition: [number, number, number]) => {
        const doorWidth = 1.0;
        const doorHeight = 2.1;
        const doorX = 0;
        const doorY = -height / 2 + doorHeight / 2;

        // Only check for door overlap if this room is the exact front room (door is centered at x=0, z=-length/2)
        // Check if this room's position is at the front center where the door is
        const isDoorRoom = Math.abs(position[0]) < 1 && Math.abs(position[2] - (-dimensions[2] / 2)) < 1;

        if (!isDoorRoom) return false;

        // Check if window is on front wall and overlaps with door
        return Math.abs(windowPosition[0] - doorX) < (doorWidth / 2 + 0.6) &&
            Math.abs(windowPosition[1] - doorY) < (doorHeight / 2 + 0.5);
    };

    // Add windows using pre-calculated positions
    if (windows.front && outerWalls.front && !isWindowOverlappingDoor(windows.front)) {
        createWindow(windows.front, 0, 'front');
    }
    if (windows.back && outerWalls.back) {
        createWindow(windows.back, 0, 'back');
    }
    if (windows.left && outerWalls.left) {
        createWindow(windows.left, Math.PI / 2, 'left');
    }
    if (windows.right && outerWalls.right) {
        createWindow(windows.right, Math.PI / 2, 'right');
    }

    return (
        <primitive object={group} position={position} />
    );
};

const GroundPlane = ({ dimensions, color }: {
    dimensions: [number, number];
    color: string;
}) => {
    const [width, length] = dimensions;

    return (
        <mesh rotation={[-Math.PI / 2, 0, 0]} position={[0, -0.1, 0]}>
            <planeGeometry args={[width, length]} />
            <meshStandardMaterial color={color} />
        </mesh>
    );
};

const Door = ({ dimensions, yOffset }: {
    dimensions: [number, number];
    yOffset: number;
}) => {
    const [width, length] = dimensions;
    const doorWidth = 1.0;
    const doorHeight = 2.1;
    const wallThickness = 0.2;

    return (
        <mesh position={[0, yOffset + doorHeight / 2, -length / 2 - wallThickness * 0.75]}>
            <boxGeometry args={[doorWidth, doorHeight, wallThickness * 1.5]} />
            <meshStandardMaterial color="#8B4513" side={THREE.DoubleSide} />
        </mesh>
    );
};

const FlatRoof = ({ dimensions, color, yOffset }: {
    dimensions: [number, number];
    color: string;
    yOffset: number;
}) => {
    const [width, length] = dimensions;
    const roofThickness = 0.3; // 30cm roof thickness

    return (
        <mesh position={[0, yOffset + roofThickness / 2 + 0.01, 0]}>
            <boxGeometry args={[width, roofThickness, length]} />
            <meshStandardMaterial color={color} />
        </mesh>
    );
};

const PointedRoof = ({ dimensions, color, yOffset }: {
    dimensions: [number, number];
    color: string;
    yOffset: number;
}) => {
    const [width, length] = dimensions;
    const roofHeight = 2; // 2m roof height

    // Create a triangular prism with rectangular base
    const geometry = new THREE.BufferGeometry();

    // Define vertices for triangular prism with rectangular base
    const vertices = new Float32Array([
        // Front triangle (at -length/2)
        -width / 2, 0, -length / 2,      // bottom left
        width / 2, 0, -length / 2,       // bottom right
        0, roofHeight, -length / 2,    // top

        // Back triangle (at +length/2)
        -width / 2, 0, length / 2,       // bottom left
        width / 2, 0, length / 2,        // bottom right
        0, roofHeight, length / 2,     // top
    ]);

    // Define faces for triangular prism
    const indices = new Uint16Array([
        // Front face
        0, 2, 1,
        // Back face
        3, 4, 5,
        // Left face
        0, 3, 2,
        2, 3, 5,
        // Right face
        1, 2, 4,
        4, 2, 5,
        // Bottom face (rectangular)
        0, 1, 3,
        3, 1, 4,
    ]);

    geometry.setAttribute('position', new THREE.BufferAttribute(vertices, 3));
    geometry.setIndex(new THREE.BufferAttribute(indices, 1));
    geometry.computeVertexNormals();

    return (
        <group position={[0, yOffset + 0.01, 0]}>
            {/* Solid roof */}
            <mesh geometry={geometry}>
                <meshBasicMaterial color={color} />
            </mesh>

            {/* Wireframe outline */}
            <lineSegments>
                <wireframeGeometry args={[geometry]} />
                <lineBasicMaterial color="#000000" linewidth={2} />
            </lineSegments>
        </group>
    );
};

// WASD Camera Controls Component
const WASDControls = ({ moveSpeed = 0.15 }) => {
    const { camera } = useThree();
    const keys = useRef({ w: false, a: false, s: false, d: false, q: false, e: false });

    // Set up key listeners
    useEffect(() => {
        const handleKeyDown = (e: KeyboardEvent) => {
            if (e.key.toLowerCase() === 'w') keys.current.w = true;
            if (e.key.toLowerCase() === 'a') keys.current.a = true;
            if (e.key.toLowerCase() === 's') keys.current.s = true;
            if (e.key.toLowerCase() === 'd') keys.current.d = true;
            if (e.key.toLowerCase() === 'q') keys.current.q = true;
            if (e.key.toLowerCase() === 'e') keys.current.e = true;
        };

        const handleKeyUp = (e: KeyboardEvent) => {
            if (e.key.toLowerCase() === 'w') keys.current.w = false;
            if (e.key.toLowerCase() === 'a') keys.current.a = false;
            if (e.key.toLowerCase() === 's') keys.current.s = false;
            if (e.key.toLowerCase() === 'd') keys.current.d = false;
            if (e.key.toLowerCase() === 'q') keys.current.q = false;
            if (e.key.toLowerCase() === 'e') keys.current.e = false;
        };

        window.addEventListener('keydown', handleKeyDown);
        window.addEventListener('keyup', handleKeyUp);

        return () => {
            window.removeEventListener('keydown', handleKeyDown);
            window.removeEventListener('keyup', handleKeyUp);
        };
    }, []);

    // Update camera position on each frame
    useFrame(() => {
        // Get camera direction vectors
        const forward = new THREE.Vector3(0, 0, -1).applyQuaternion(camera.quaternion);
        const right = new THREE.Vector3(1, 0, 0).applyQuaternion(camera.quaternion);

        // Ensure movement is only on the horizontal plane
        forward.y = 0;
        forward.normalize();
        right.y = 0;
        right.normalize();

        // WASD movement
        if (keys.current.w) camera.position.addScaledVector(forward, moveSpeed);
        if (keys.current.s) camera.position.addScaledVector(forward, -moveSpeed);
        if (keys.current.a) camera.position.addScaledVector(right, -moveSpeed);
        if (keys.current.d) camera.position.addScaledVector(right, moveSpeed);

        // Q/E for vertical movement
        if (keys.current.q) camera.position.y += moveSpeed;
        if (keys.current.e) camera.position.y -= moveSpeed;
    });

    return null; // This component doesn't render anything
};

const HouseGen = () => {
    const [dimensions, setDimensions] = useState<HouseDimensions>({
        length: 10,
        width: 10,
        height: 3
    });

    const [lotDimensions, setLotDimensions] = useState<[number, number]>([15, 15]);
    const [stories, setStories] = useState<Story[]>([
        { numRooms: 4, height: 3 }
    ]);
    const [externalWallColor, setExternalWallColor] = useState('#D2D8E4');
    const [internalWallColor, setInternalWallColor] = useState('#E8E8E8');
    const [groundColor, setGroundColor] = useState('#8FBC8F');
    const [roofType, setRoofType] = useState<'flat' | 'pointed'>('flat');
    const [roofColor, setRoofColor] = useState('#8B4513');

    const defaultDimensions: HouseDimensions = {
        length: 10,
        width: 10,
        height: 3
    };

    const defaultLotDimensions: [number, number] = [15, 15];
    const defaultStories: Story[] = [{ numRooms: 4, height: 3 }];

    const handleDimensionChange = (dimension: 'length' | 'width' | 'height', value: number) => {
        setDimensions(prev => ({
            ...prev,
            [dimension]: value
        }));
    };

    const handleLotDimensionChange = (dimension: 'width' | 'length', value: number) => {
        setLotDimensions(prev => {
            if (dimension === 'width') {
                return [value, prev[1]];
            } else {
                return [prev[0], value];
            }
        });
    };

    const handleStoryChange = (storyIndex: number, field: 'numRooms' | 'height', value: number) => {
        setStories(prev => prev.map((story, index) =>
            index === storyIndex
                ? { ...story, [field]: value }
                : story
        ));
    };

    const addStory = () => {
        setStories(prev => [...prev, { numRooms: 2, height: 3 }]);
    };

    const removeStory = (storyIndex: number) => {
        if (stories.length > 1) {
            setStories(prev => prev.filter((_, index) => index !== storyIndex));
        }
    };

    const handleReset = () => {
        setDimensions(defaultDimensions);
        setLotDimensions(defaultLotDimensions);
        setStories(defaultStories);
        setExternalWallColor('#D2D8E4');
        setInternalWallColor('#E8E8E8');
        setGroundColor('#8FBC8F');
        setRoofType('flat');
        setRoofColor('#8B4513');
    };

    // Calculate room layout using the utility function
    const roomLayout = useMemo(() => {
        return calculateRoomLayout(stories, dimensions);
    }, [stories, dimensions]);

    // Calculate total house height for roof positioning
    const totalHouseHeight = useMemo(() => {
        return stories.reduce((total, story) => total + story.height, 0);
    }, [stories]);

    return (
        <div className="w-full h-screen relative">
            {/* Control Panel - Split into two columns */}
            <div className="absolute top-4 left-4 bg-white/90 backdrop-blur-sm p-4 rounded-lg shadow-lg z-10 max-h-[90vh] overflow-y-auto">
                <h2 className="text-lg font-semibold mb-4 text-gray-800">House Layout (Meters)</h2>

                <div className="grid grid-cols-2 gap-4">
                    {/* Left Column */}
                    <div className="space-y-4">
                        <div className="border-b border-gray-200 pb-3">
                            <h3 className="text-md font-medium text-gray-700 mb-3">House Dimensions</h3>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Length: {dimensions.length}m
                                </label>
                                <input
                                    type="range"
                                    min="5"
                                    max="20"
                                    step="0.5"
                                    value={dimensions.length}
                                    onChange={(e) => handleDimensionChange('length', parseFloat(e.target.value))}
                                    className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Width: {dimensions.width}m
                                </label>
                                <input
                                    type="range"
                                    min="4"
                                    max="15"
                                    step="0.5"
                                    value={dimensions.width}
                                    onChange={(e) => handleDimensionChange('width', parseFloat(e.target.value))}
                                    className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Height: {dimensions.height}m
                                </label>
                                <input
                                    type="range"
                                    min="2.5"
                                    max="6"
                                    step="0.1"
                                    value={dimensions.height}
                                    onChange={(e) => handleDimensionChange('height', parseFloat(e.target.value))}
                                    className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                                />
                            </div>
                        </div>

                        <div className="border-b border-gray-200 pb-3">
                            <h3 className="text-md font-medium text-gray-700 mb-3">Roof</h3>

                            <div className="mb-3">
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Roof Type
                                </label>
                                <select
                                    value={roofType}
                                    onChange={(e) => setRoofType(e.target.value as 'flat' | 'pointed')}
                                    className="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                    <option value="flat">Flat Roof</option>
                                    <option value="pointed">Pointed Roof</option>
                                </select>
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Roof Color
                                </label>
                                <input
                                    type="color"
                                    value={roofColor}
                                    onChange={(e) => setRoofColor(e.target.value)}
                                    className="w-full h-10 rounded-lg cursor-pointer"
                                />
                            </div>
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                External Wall Color
                            </label>
                            <input
                                type="color"
                                value={externalWallColor}
                                onChange={(e) => setExternalWallColor(e.target.value)}
                                className="w-full h-10 rounded-lg cursor-pointer"
                            />
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Internal Wall Color
                            </label>
                            <input
                                type="color"
                                value={internalWallColor}
                                onChange={(e) => setInternalWallColor(e.target.value)}
                                className="w-full h-10 rounded-lg cursor-pointer"
                            />
                        </div>
                    </div>

                    {/* Right Column */}
                    <div className="space-y-4">
                        <div className="border-b border-gray-200 pb-3">
                            <h3 className="text-md font-medium text-gray-700 mb-3">Stories ({stories.length})</h3>

                            {stories.map((story, storyIndex) => (
                                <div key={storyIndex} className="mb-3 p-2 bg-gray-50 rounded-lg">
                                    <div className="flex items-center justify-between mb-2">
                                        <span className="text-xs font-medium text-gray-700">
                                            Story {storyIndex + 1}
                                        </span>
                                        {stories.length > 1 && (
                                            <button
                                                onClick={() => removeStory(storyIndex)}
                                                className="text-red-500 hover:text-red-700 text-xs"
                                            >
                                                Remove
                                            </button>
                                        )}
                                    </div>

                                    <div className="space-y-1">
                                        <div>
                                            <label className="block text-xs font-medium text-gray-600 mb-1">
                                                Rooms: {story.numRooms}
                                            </label>
                                            <input
                                                type="range"
                                                min="1"
                                                max="9"
                                                step="1"
                                                value={story.numRooms}
                                                onChange={(e) => handleStoryChange(storyIndex, 'numRooms', parseInt(e.target.value))}
                                                className="w-full h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                                            />
                                        </div>

                                        <div>
                                            <label className="block text-xs font-medium text-gray-600 mb-1">
                                                Height: {story.height}m
                                            </label>
                                            <input
                                                type="range"
                                                min="2.5"
                                                max="6"
                                                step="0.1"
                                                value={story.height}
                                                onChange={(e) => handleStoryChange(storyIndex, 'height', parseFloat(e.target.value))}
                                                className="w-full h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                                            />
                                        </div>
                                    </div>
                                </div>
                            ))}

                            <button
                                onClick={addStory}
                                className="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm"
                            >
                                Add Story
                            </button>
                        </div>

                        <div className="border-b border-gray-200 pb-3">
                            <h3 className="text-md font-medium text-gray-700 mb-3">Lot Area</h3>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Lot Width: {lotDimensions[0]}m
                                </label>
                                <input
                                    type="range"
                                    min="10"
                                    max="30"
                                    step="1"
                                    value={lotDimensions[0]}
                                    onChange={(e) => handleLotDimensionChange('width', parseInt(e.target.value))}
                                    className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Lot Length: {lotDimensions[1]}m
                                </label>
                                <input
                                    type="range"
                                    min="10"
                                    max="30"
                                    step="1"
                                    value={lotDimensions[1]}
                                    onChange={(e) => handleLotDimensionChange('length', parseInt(e.target.value))}
                                    className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Ground Color
                                </label>
                                <input
                                    type="color"
                                    value={groundColor}
                                    onChange={(e) => setGroundColor(e.target.value)}
                                    className="w-full h-10 rounded-lg cursor-pointer"
                                />
                            </div>
                        </div>

                        <div className="pt-2">
                            <button
                                onClick={handleReset}
                                className="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
                            >
                                Reset to Default
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {/* Navigation Instructions */}
            <div className="absolute top-4 right-4 bg-black/70 text-white p-3 rounded-lg text-sm">
                <div className="font-semibold mb-2">Navigation:</div>
                <div>W/S - Forward/Back</div>
                <div>A/D - Left/Right</div>
                <div>Q/E - Up/Down</div>
                <div>Mouse - Rotate/Zoom</div>
            </div>

            <Canvas camera={{ position: [15, 15, 15] }}>
                <Suspense fallback={null}>
                    {/* WASD Controls */}
                    <WASDControls />

                    {/* Lighting */}
                    <ambientLight intensity={0.5} />
                    <directionalLight position={[10, 10, 5]} intensity={1} />

                    {/* Ground Plane */}
                    <GroundPlane dimensions={lotDimensions} color={groundColor} />

                    {/* Door */}
                    <Door dimensions={[dimensions.width, dimensions.length]} yOffset={0} />

                    {/* Rooms */}
                    {roomLayout.map((room, index) => (
                        <Room
                            key={index}
                            position={room.position}
                            dimensions={room.dimensions}
                            externalColor={externalWallColor}
                            internalColor={internalWallColor}
                            windows={room.windows}
                            outerWalls={room.outerWalls}
                            internalWalls={room.internalWalls}
                        />
                    ))}

                    {/* Roof */}
                    {roofType === 'flat' ? (
                        <FlatRoof
                            dimensions={[dimensions.width + 1, dimensions.length + 1]}
                            color={roofColor}
                            yOffset={totalHouseHeight}
                        />
                    ) : (
                        <PointedRoof
                            dimensions={[dimensions.width + 1, dimensions.length + 1]}
                            color={roofColor}
                            yOffset={totalHouseHeight}
                        />
                    )}

                    {/* Camera Controls */}
                    <OrbitControls />
                </Suspense>
            </Canvas>
        </div>
    );
};

export default HouseGen;