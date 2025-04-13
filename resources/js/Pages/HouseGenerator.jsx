import React, { useMemo, useState, useEffect, useRef } from "react";
import { Canvas, useFrame, useThree } from "@react-three/fiber";
import { OrbitControls, Sky } from "@react-three/drei";
import * as THREE from "three";

const WALL_HEIGHT = 1;
const WALL_THICKNESS = 0.2;
const DOOR_WIDTH = 0.85;
const DOOR_HEIGHT = 1.3;
const DOOR_MARGIN = 0.2;
const ROOF_OFFSET = 0.2;
// Default number of stories (now controlled by state)

// Window properties
const WINDOW_WIDTH = 0.5;  // Width of each pane (smaller for double-pane)
const WINDOW_HEIGHT = 0.5;  // Height of window
const WINDOW_MARGIN = 0.5;  // Margin between window sets
const WINDOW_PANE_GAP = 0.05; // Gap between the two panes of a window

// WASD Camera Controls Component
const WASDControls = ({ moveSpeed = 0.15, lookSpeed = 0.005 }) => {
    const { camera, gl } = useThree();
    const keys = useRef({ w: false, a: false, s: false, d: false, shift: false, space: false, c: false });
    const mousePos = useRef({ x: 0, y: 0 });

    // Store Euler angles to prevent tilting
    const euler = useRef(new THREE.Euler(0, 0, 0, 'YXZ'));

    // Initialize camera rotation
    useEffect(() => {
        // Set initial rotation
        euler.current.setFromQuaternion(camera.quaternion);

        // Ensure camera is using the correct up vector
        camera.up.set(0, 1, 0);
    }, [camera]);

    // Set up key listeners
    useEffect(() => {
        const handleKeyDown = (e) => {
            if (e.key.toLowerCase() === 'w') keys.current.w = true;
            if (e.key.toLowerCase() === 'a') keys.current.a = true;
            if (e.key.toLowerCase() === 's') keys.current.s = true;
            if (e.key.toLowerCase() === 'd') keys.current.d = true;
            if (e.key === 'Shift') keys.current.shift = true;
            if (e.key === ' ') keys.current.space = true;
            if (e.key.toLowerCase() === 'c') keys.current.c = true;
        };

        const handleKeyUp = (e) => {
            if (e.key.toLowerCase() === 'w') keys.current.w = false;
            if (e.key.toLowerCase() === 'a') keys.current.a = false;
            if (e.key.toLowerCase() === 's') keys.current.s = false;
            if (e.key.toLowerCase() === 'd') keys.current.d = false;
            if (e.key === 'Shift') keys.current.shift = false;
            if (e.key === ' ') keys.current.space = false;
            if (e.key.toLowerCase() === 'c') keys.current.c = false;
        };

        // Lock pointer when canvas is clicked
        const handleCanvasClick = () => {
            if (!document.pointerLockElement) {
                gl.domElement.requestPointerLock();
            }
        };

        // Handle mouse movement for camera rotation
        const handleMouseMove = (e) => {
            if (document.pointerLockElement === gl.domElement) {
                // Use movementX/Y for smooth camera rotation
                mousePos.current.x = e.movementX;
                mousePos.current.y = e.movementY;
            }
        };

        // Prevent context menu on right-click
        const handleContextMenu = (e) => {
            e.preventDefault();
        };

        window.addEventListener('keydown', handleKeyDown);
        window.addEventListener('keyup', handleKeyUp);
        gl.domElement.addEventListener('click', handleCanvasClick);
        window.addEventListener('mousemove', handleMouseMove);
        gl.domElement.addEventListener('contextmenu', handleContextMenu);

        return () => {
            window.removeEventListener('keydown', handleKeyDown);
            window.removeEventListener('keyup', handleKeyUp);
            gl.domElement.removeEventListener('click', handleCanvasClick);
            window.removeEventListener('mousemove', handleMouseMove);
            gl.domElement.removeEventListener('contextmenu', handleContextMenu);
            if (document.pointerLockElement === gl.domElement) {
                document.exitPointerLock();
            }
        };
    }, [gl]);

    // Update camera position and rotation on each frame
    useFrame(() => {
        // Movement speed (faster with shift)
        const currentSpeed = keys.current.shift ? moveSpeed * 2 : moveSpeed;

        // Get camera direction vectors
        const forward = new THREE.Vector3(0, 0, -1).applyQuaternion(camera.quaternion);
        const right = new THREE.Vector3(1, 0, 0).applyQuaternion(camera.quaternion);

        // Ensure movement is only on the horizontal plane (no vertical movement from looking up/down)
        forward.y = 0;
        forward.normalize();
        right.y = 0;
        right.normalize();

        // WASD movement
        if (keys.current.w) camera.position.addScaledVector(forward, currentSpeed);
        if (keys.current.s) camera.position.addScaledVector(forward, -currentSpeed);
        if (keys.current.a) camera.position.addScaledVector(right, -currentSpeed);
        if (keys.current.d) camera.position.addScaledVector(right, currentSpeed);

        // Vertical movement (Space to go up, C to go down)
        if (keys.current.space) camera.position.y += currentSpeed;
        if (keys.current.c) camera.position.y -= currentSpeed;

        // Mouse look (when pointer is locked)
        if (document.pointerLockElement === gl.domElement) {
            // Get current Euler angles
            euler.current.setFromQuaternion(camera.quaternion);

            // Determine the dominant direction of mouse movement
            const absX = Math.abs(mousePos.current.x);
            const absY = Math.abs(mousePos.current.y);

            if (absX > absY && absX > 1) {
                // Horizontal movement is dominant - only rotate horizontally
                euler.current.y -= mousePos.current.x * lookSpeed;
            } else if (absY > absX && absY > 1) {
                // Vertical movement is dominant - only rotate vertically
                // Limit vertical rotation to avoid flipping
                euler.current.x -= mousePos.current.y * lookSpeed;
                euler.current.x = Math.max(-Math.PI / 2, Math.min(Math.PI / 2, euler.current.x));
            }

            // Apply rotation while maintaining the up vector
            camera.quaternion.setFromEuler(euler.current);
            camera.up.set(0, 1, 0); // Ensure the up vector stays pointing up

            // Reset mouse movement
            mousePos.current.x = 0;
            mousePos.current.y = 0;
        }
    });

    return null; // This component doesn't render anything
};

const Wall = ({ hasDoor = false, position, rotation, doorX = 0, width, color = 'white', windows = [] }) => {
    const wallShape = new THREE.Shape();
    wallShape.moveTo(-width, -WALL_HEIGHT);
    wallShape.lineTo(width, -WALL_HEIGHT);
    wallShape.lineTo(width, WALL_HEIGHT);
    wallShape.lineTo(-width, WALL_HEIGHT);
    wallShape.lineTo(-width, -WALL_HEIGHT);

    // Add door if needed
    if (hasDoor) {
        const doorHole = new THREE.Path();
        doorHole.moveTo(doorX - DOOR_WIDTH / 2, -WALL_HEIGHT);
        doorHole.lineTo(doorX + DOOR_WIDTH / 2, -WALL_HEIGHT);
        doorHole.lineTo(doorX + DOOR_WIDTH / 2, -WALL_HEIGHT + DOOR_HEIGHT);
        doorHole.lineTo(doorX - DOOR_WIDTH / 2, -WALL_HEIGHT + DOOR_HEIGHT);
        doorHole.lineTo(doorX - DOOR_WIDTH / 2, -WALL_HEIGHT);
        wallShape.holes.push(doorHole);
    }

    // Add windows
    windows.forEach(window => {
        const { x, y } = window;
        // Create rectangular window hole for each pane
        let windowHole = new THREE.Path();
        windowHole.moveTo(x - WINDOW_WIDTH / 2, y - WINDOW_HEIGHT / 2);
        windowHole.lineTo(x + WINDOW_WIDTH / 2, y - WINDOW_HEIGHT / 2);
        windowHole.lineTo(x + WINDOW_WIDTH / 2, y + WINDOW_HEIGHT / 2);
        windowHole.lineTo(x - WINDOW_WIDTH / 2, y + WINDOW_HEIGHT / 2);
        windowHole.lineTo(x - WINDOW_WIDTH / 2, y - WINDOW_HEIGHT / 2);
        wallShape.holes.push(windowHole);
    });

    const extrudeSettings = { depth: WALL_THICKNESS, bevelEnabled: false };

    // Create window glass and frames
    const windowElements = windows.map((window, index) => {
        const { x, y } = window;
        const glassDepth = WALL_THICKNESS;

        return (
            <group key={index} position={[x, y, 0]}>
                <mesh position={[0, 0, 0.1]}> {/* Slightly in front of frame */}
                    <boxGeometry args={[WINDOW_WIDTH, WINDOW_HEIGHT, glassDepth]} />
                    <meshPhysicalMaterial
                        color='black'
                        transparent={true}
                        opacity={0.3}
                        metalness={0.3}
                        roughness={0.01}
                        transmission={0.9} // Glass-like transparency
                    />
                </mesh>
            </group>
        );
    });

    return (
        <group position={position}>
            {/* Wall with window holes */}
            <mesh rotation={rotation}>
                <extrudeGeometry args={[wallShape, extrudeSettings]} />
                <meshStandardMaterial color={color} />
            </mesh>

            {/* Window glass elements - positioned relative to the wall */}
            <group rotation={rotation}>
                {windowElements}
            </group>
        </group>
    );
};

// Utility function to generate random windows for a wall
const generateWindowPane = (x) => {
    const windows = [];
    const windowY = 0.2;
    windows.push({
        x: -x - (WINDOW_WIDTH / 2 + WINDOW_PANE_GAP / 2),
        y: windowY,
    });
    windows.push({
        x: -x + (WINDOW_WIDTH / 2 + WINDOW_PANE_GAP / 2),
        y: windowY,
    });
    windows.push({
        x: x - (WINDOW_WIDTH / 2 + WINDOW_PANE_GAP / 2),
        y: windowY,
    });
    windows.push({
        x: x + (WINDOW_WIDTH / 2 + WINDOW_PANE_GAP / 2),
        y: windowY,
    });
    return windows;
};

// 🏠 Custom Roof with Rectangular Base
const Roof = ({ width, length, height, rotation, y = WALL_HEIGHT }) => {
    const BASE_OFFSET = 0.5; // Controls how much the peak is inset

    const geometry = useMemo(() => {
        const vertices = new Float32Array([
            // Base rectangle (extended for overhang)
            -width / 2 - ROOF_OFFSET, 0, -length / 2 - ROOF_OFFSET, // 0
            width / 2 + ROOF_OFFSET, 0, -length / 2 - ROOF_OFFSET,  // 1
            width / 2 + ROOF_OFFSET, 0, length / 2 + ROOF_OFFSET,   // 2
            -width / 2 - ROOF_OFFSET, 0, length / 2 + ROOF_OFFSET,  // 3

            // **Inset Roof Peaks (to avoid touching the corners)**
            -width / 2 + BASE_OFFSET, height, 0,  // 4 (Left Peak)
            width / 2 - BASE_OFFSET, height, 0,   // 5 (Right Peak)
        ]);

        const indices = new Uint16Array([
            // Side faces
            0, 1, 4,
            1, 2, 5,
            2, 3, 5,
            3, 0, 4,

            // Triangular Top Connection
            4, 5, 1,
            4, 5, 3,

            // Base (rectangle)
            0, 1, 2,
            2, 3, 0,
        ]);

        const bufferGeometry = new THREE.BufferGeometry();
        bufferGeometry.setAttribute("position", new THREE.BufferAttribute(vertices, 3));
        bufferGeometry.setIndex(new THREE.BufferAttribute(indices, 1));

        return bufferGeometry;
    }, [width, length, height]); // Rebuild when size updates

    return (
        <mesh rotation={rotation} position={[0, y, 0]} geometry={geometry}>
            <meshStandardMaterial side={THREE.DoubleSide} color="brown" />
        </mesh>
    );
};

const Room = ({ roomWidth, roomLength, quadrantX = 1, quadrantY = 1, doorSide = false, doorFront = false, wallSide = true, numWindows = 1 }) => {
    return (
        <group>
            {
                wallSide &&
                <Wall
                    hasDoor={doorSide}
                    position={[quadrantX > 0 ? 0 : -WALL_THICKNESS, 0, quadrantY * roomLength / 2]}
                    rotation={[0, Math.PI / 2, 0]}
                    width={roomLength / 2}
                />
            }
            <Wall
                hasDoor={doorFront}
                position={[quadrantX * roomWidth / 2, 0, 0]}
                rotation={[0, 0, 0]}
                width={roomWidth / 2}
            />
        </group>
    )
}

const ConnectedRooms = ({ roomWidth, roomLength, numWindows }) => {
    return (<group>
        <Room doorSide={true} roomWidth={roomWidth} doorFront={true} roomLength={roomLength} quadrantX={-1} quadrantY={1} numWindows={numWindows} />
        <Room doorFront={true} wallSide={false} roomWidth={roomWidth} roomLength={roomLength} quadrantX={1} quadrantY={1} numWindows={numWindows} />
    </group>)
}

const UnconnectedRooms = ({ roomWidth, roomLength, numWindows }) => {
    return (<group>
        <Room doorFront={true} roomWidth={roomWidth} roomLength={roomLength} quadrantX={-1} quadrantY={1} numWindows={numWindows} />
        <Room doorFront={true} roomWidth={roomWidth} roomLength={roomLength} quadrantX={1} quadrantY={1} numWindows={numWindows} />
    </group>)
}

const House = ({ roofHeight, renderGrass, doorX, roomWidth, roomLength, numStories, numWindows = 2 }) => {
    return (
        <group rotation={[0, Math.PI * 5 / 4, 0]}>
            {renderGrass && (
                <mesh position={[0, -0.01 - WALL_HEIGHT, 0]} rotation={[-Math.PI / 2, 0, 0]}>
                    <planeGeometry args={[1000, 1000]} />
                    <meshStandardMaterial color="green" />
                </mesh>
            )}
            {
                [...Array(numStories)].map((_, i) =>
                    <group key={i} position={[0, i * WALL_HEIGHT * 2, 0]}>
                        {/* Front wall with door and windows */}
                        <Wall
                            hasDoor={i == 0}
                            position={[0, 0, -roomLength]}
                            doorX={doorX}
                            width={roomWidth}
                            windows={i > 0 ? generateWindowPane(roomWidth / 2) : []}
                        />

                        {/* Back wall with windows */}
                        <Wall
                            position={[0, 0, roomLength - WALL_THICKNESS]}
                            width={roomWidth}
                            windows={generateWindowPane(roomWidth / 2)}
                        />

                        {/* Right wall with windows */}
                        <Wall
                            position={[roomWidth - WALL_THICKNESS, 0, 0]}
                            rotation={[0, Math.PI / 2, 0]}
                            width={roomLength}
                            windows={generateWindowPane(roomLength / 2)}
                        />

                        {/* Left wall with windows */}
                        <Wall
                            position={[-roomWidth, 0, 0]}
                            rotation={[0, Math.PI / 2, 0]}
                            width={roomLength}
                            windows={generateWindowPane(roomLength / 2)}
                        />
                        {false && <UnconnectedRooms roomLength={roomLength} roomWidth={roomWidth} numWindows={numWindows} />}
                        {false && <ConnectedRooms roomLength={roomLength} roomWidth={roomWidth} numWindows={numWindows} />}
                        {true && <SoloRoom roomLength={roomLength} roomWidth={roomWidth} numWindows={numWindows} />}

                        <mesh position={[0, -1, 0]}>
                            <boxGeometry args={[roomWidth * 2.001, 0.2, roomLength * 2.001]} ></boxGeometry>
                            <meshStandardMaterial color="gray" />
                        </mesh>
                    </group>
                )
            }
            <Roof
                width={roomWidth * 2}
                length={roomLength * 2}
                height={roofHeight}
                y={1 + (numStories - 1) * 2}
            />
            <ambientLight intensity={0.5} />
            <directionalLight position={[5, 5, 5]} intensity={1} />
        </group>
    );
};

const HouseScene = () => {
    const [roofHeight, setRoofHeight] = useState(1);
    const [renderGrass, setRenderGrass] = useState(false);
    const [doorX, setDoorX] = useState(0);
    const [roomWidth, setRoomWidth] = useState(Math.random() * 1 + 3);
    const [roomLength, setRoomLength] = useState(Math.random() * 1 + 3);
    const [numStories, setNumStories] = useState(1);

    const minDoorX = -roomWidth + DOOR_WIDTH / 2 + DOOR_MARGIN;
    const maxDoorX = roomWidth - DOOR_WIDTH / 2 - DOOR_MARGIN;

    // State to toggle between control modes
    const [useWASDControls, setUseWASDControls] = useState(false);

    return (
        <div className="h-screen w-full relative">
            <Canvas camera={{ position: [6, 4, 6], fov: 60 }} fog={{ color: "green", near: 10, far: 50 }}>
                {useWASDControls ? <WASDControls /> : <OrbitControls />}
                <Sky sunPosition={[100, 20, 100]} />
                <House
                    roofHeight={roofHeight}
                    renderGrass={renderGrass}
                    doorX={doorX}
                    roomWidth={roomWidth}
                    roomLength={roomLength}
                    numStories={numStories}
                />
            </Canvas>

            <div className="absolute bottom-5 right-32 transform bg-white p-3 rounded shadow-lg">
                <div className="mb-4 p-2 bg-gray-100 rounded">
                    <label className="block text-sm font-bold mb-2">Camera Controls</label>
                    <div className="flex items-center">
                        <button
                            onClick={() => setUseWASDControls(false)}
                            className={`px-3 py-1 mr-2 rounded ${!useWASDControls ? 'bg-blue-500 text-white' : 'bg-gray-200'}`}
                        >
                            Orbit
                        </button>
                        <button
                            onClick={() => setUseWASDControls(true)}
                            className={`px-3 py-1 rounded ${useWASDControls ? 'bg-blue-500 text-white' : 'bg-gray-200'}`}
                        >
                            WASD
                        </button>
                    </div>
                    {useWASDControls && (
                        <div className="mt-2 text-xs text-gray-600">
                            <p>W,A,S,D: Move | Space/C: Up/Down</p>
                            <p>Shift: Speed up | Click canvas to look around</p>
                            <p className="text-xs italic">Click to lock cursor, ESC to release</p>
                        </div>
                    )}
                </div>

                <label className="block text-sm font-bold">Roof Height: {roofHeight.toFixed(1)}</label>
                <input type="range" min="1" max="4" step="0.1" value={roofHeight} onChange={(e) => setRoofHeight(parseFloat(e.target.value))} className="w-40" />
                <div className="mt-3">
                    <label className="block text-sm font-bold">Door X Position: {doorX.toFixed(1)}</label>
                    <input type="range" min={minDoorX} max={maxDoorX} step="0.1" value={doorX} onChange={(e) => setDoorX(parseFloat(e.target.value))} className="w-40" />
                </div>
                <div className="mt-3">
                    <label className="block text-sm font-bold">Room Width: {roomWidth.toFixed(1)}</label>
                    <input type="range" min="3" max="7" step="0.1" value={roomWidth} onChange={(e) => setRoomWidth(parseFloat(e.target.value))} className="w-40" />
                </div>
                <div className="mt-3">
                    <label className="block text-sm font-bold">Room Length: {roomLength.toFixed(1)}</label>
                    <input type="range" min="3" max="7" step="0.1" value={roomLength} onChange={(e) => setRoomLength(parseFloat(e.target.value))} className="w-40" />
                </div>
                <div className="mt-3">
                    <label className="block text-sm font-bold"># Stories: {numStories}</label>
                    <input type="range" min="1" max="5" step="1" value={numStories} onChange={(e) => setNumStories(parseInt(e.target.value))} className="w-40" />
                </div>
                <div className="mt-3">
                    <label className="block text-sm font-bold">Render Grass</label>
                    <input type="checkbox" checked={renderGrass} onChange={() => setRenderGrass(!renderGrass)} className="ml-2" />
                </div>
            </div>
        </div>
    );
};

export default HouseScene;
